<?php

declare(strict_types=1);

namespace MRC\StringCalculator;

use InvalidArgumentException;
use MRC\StringCalculator\Rules\Operations\AddRule;
use MRC\StringCalculator\Rules\Operations\DivideRule;
use MRC\StringCalculator\Rules\Operations\MultiplyRule;
use MRC\StringCalculator\Rules\Operations\ParenthesesRule;
use MRC\StringCalculator\Rules\Operations\SubtractRule;
use MRC\StringCalculator\Rules\Priority\ExpressionPriorityRule;
use MRC\StringCalculator\Rules\Validation\ConsecutiveOperatorsRule;
use MRC\StringCalculator\Rules\Validation\InvalidCharacterRule;

final class ExpressionEvaluator
{
    private array $rules;
    private array $errors = [];

    private ExpressionPriorityRule $priorityRule;

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
            new ConsecutiveOperatorsRule()
        ];

        $this->priorityRule = new ExpressionPriorityRule(
            new ParenthesesRule($this),
            new MultiplyRule(),
            new DivideRule($this),
            new AddRule(),
            new SubtractRule(),
        );
    }

    public function evaluate(string $expression): string
    {
        try {
            $this->errors = [];
            $this->validateExpression($expression);

            $parts = $this->splitExpression($expression);
            $result = $this->calculateExpression($parts);

            if ($this->errors !== []) {
                throw new InvalidArgumentException(implode("\n", $this->errors));
            }

            return $result[0];
        } catch (InvalidArgumentException $exception) {
            return $exception->getMessage();
        }
    }

    public function calculateExpression(array $parts): array
    {
        return $this->priorityRule->apply($parts);
    }

    public function addError(string $error): void
    {
        $this->errors[] = $error;
    }

    private function validateExpression(string $expression): void
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            $errors = array_merge($errors, $rule->validate($expression));
        }

        if ($errors !== []) {
            throw new InvalidArgumentException(implode("\n", $errors));
        }
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
}
