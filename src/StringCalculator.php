<?php

declare(strict_types=1);

namespace MRC\StringCalculator;

use InvalidArgumentException;

use MRC\StringCalculator\Rules\Validation\MultipleErrorsRule;


final class StringCalculator
{
    private ExpressionEvaluator $evaluator;
    private array $rules;

    public function __construct()
    {
        $this->evaluator = new ExpressionEvaluator();

        $this->rules = [
            new MultipleErrorsRule(),
        ];
    }

    public function add(string $numbers): string
    {
        return $this->calculate($numbers, fn(array $numbers) => array_sum($numbers));
    }

    public function multiply(string $numbers): string
    {
        return $this->calculate($numbers, fn(array $numbers) => array_product($numbers));
    }

    public function divide(string $numbers): string
    {
        return $this->calculate($numbers, fn(array $numbers) => $this->divideNumbers($numbers));
    }

    public function evaluate(string $expression): string
    {
        return $this->evaluator->evaluate($expression);
    }

    private function calculate(string $numbers, callable $operation): string
    {
        try {

            $errors = [];
            foreach ($this->rules as $rule) {
                $errors = array_merge($errors, $rule->validate($numbers));
            }

            if ($errors !== []) {
                throw new InvalidArgumentException(implode("\n", $errors));
            }

            if ($this->isEmpty($numbers)) {
                return '0';
            }

            $numbers = $this->normalizeSeparators($numbers);
            $parts = $this->splitNumbers($numbers);

            $values = array_map('floatval', $parts);

            return (string) $operation($values);

        } catch (InvalidArgumentException $exception) {
            return $exception->getMessage();
        }
    }

    private function isEmpty(string $number): bool
    {
        return $number === '';
    }

    private function normalizeSeparators(string $number): string
    {
        if (str_starts_with($number, "//")) {
            [$separator, $number] = $this->extractCustomSeparator($number);

            return str_replace($separator, ',', $number);
        }

        return str_replace("\n", ',', $number);
    }

    private function extractCustomSeparator(string $number): array
    {
        $separatorEnd = strpos($number, "\n");
        //\n\n

        $separator = substr($number, 2, $separatorEnd - 2);
        $number = substr($number, $separatorEnd + 1);

        return [$separator, $number];
    }

    private function splitNumbers(string $numbers): array
    {
        return explode(',', $numbers);
    }

    private function divideNumbers(array $numbers): float
    {
        $result = $numbers[0];

        foreach (array_slice($numbers, 1) as $number) {

            if ($number === 0.0) {
                throw new InvalidArgumentException('Division by zero not allowed');
            }

            $result /= $number;
        }

        return $result;
    }
}

