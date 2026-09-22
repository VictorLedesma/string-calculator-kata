<?php

declare(strict_types=1);

namespace MRC\StringCalculator;

use DivisionByZeroError;
use InvalidArgumentException;
use MRC\StringCalculator\Rules\Validation\InvalidCharacterRule;
use MRC\StringCalculator\Rules\Validation\DivisionByZeroRule;

final class ExpressionEvaluator
{

    private array $rules;

    private const OPERATORS = [
        '+',
        '-',
        '*',
        '/',
        '(',
        ')',
    ];

    public function __construct()
    {
        $this->rules = [
            new InvalidCharacterRule(),
            new DivisionByZeroRule(),
        ];

    }

    public function evaluate(string $expression): string
    {
        try {
            $errors = [];
            foreach ($this->rules as $rule) {
                $errors = array_merge($errors, $rule->validate($expression));
            }

            if ($errors !== []) {
                throw new InvalidArgumentException(implode("\n", $errors));
            }

            $parts = $this->splitExpression($expression);

            return (string) $this->calculateExpression($parts);

        } catch (InvalidArgumentException $exception) {
            return $exception->getMessage();
        }
    }

    private function calculateExpression(array $parts): float
    {
        $parts = $this->calculateParentheses($parts);

        $parts = $this->calculateMultiplicationAndDivision($parts);

        return $this->calculateAdditionAndSubtraction($parts);

    }

    private function splitExpression(string $expression): array
    {
        $parts = [];
        $number = '';

        foreach (str_split($expression) as $character) {

            if ($this->isOperator($character)) {

                if ($number !== '') {
                    $parts[] = $number;
                    $number = '';
                }

                $parts[] = $character;
                continue;
            }
            $number .= $character;
        }

        if ($number !== '') {
            $parts[] = $number;
        }
        return $parts;
    }

    private function isOperator(string $character): bool
    {
        return in_array($character, self::OPERATORS, true);
    }

    private function calculateParentheses(array $parts): array
    {
        while (in_array('(', $parts, true)) {
            $openPosition = array_search('(', $parts, true);
            $closePosition = array_search(')', $parts, true);

            $inside = array_slice($parts, $openPosition + 1, $closePosition - $openPosition - 1);

            $result = $this->calculateExpression($inside);

            array_splice($parts, $openPosition, $closePosition - $openPosition + 1, [(string) $result]);
        }
        return $parts;

    }

    private function calculateMultiplicationAndDivision(array $parts): array
    {
        while (true) {
            $operatorPosition = null;

            foreach ($parts as $position => $part) {
                if ($part === '*' || $part === '/') {
                    $operatorPosition = $position;
                    break;
                }
            }

            if ($operatorPosition === null) {
                return $parts;
            }

            $left = (float) $parts[$operatorPosition - 1];
            $operator = $parts[$operatorPosition];
            $right = (float) $parts[$operatorPosition + 1];

            if ($operator === '*') {
                $result = $left * $right;

            } else {
                $result = $left / $right;
            }

            array_splice($parts, $operatorPosition - 1, 3, [(string) $result]);
        }
    }

    private function calculateAdditionAndSubtraction(array $parts): float
    {
        $result = (float) $parts[0];

        for ($i = 1; $i < count($parts); $i += 2) {
            $operator = $parts[$i];
            $number = (float) $parts[$i + 1];

            if ($operator === '+') {
                $result += $number;
                continue;
            }

            if ($operator === '-') {
                $result -= $number;
                continue;
            }

        }
        return $result;
    }

}
