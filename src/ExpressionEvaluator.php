<?php

declare(strict_types=1);

namespace MRC\StringCalculator;

use InvalidArgumentException;

final class ExpressionEvaluator
{
    private const OPERATORS = [
        '+',
        '-',
        '*',
        '/',
        '(',
        ')',
    ];

    public function evaluate(string $expression): string
    {
        try {

            if (str_contains($expression, '/0')) {
                throw new InvalidArgumentException('Division by zero not allowed');
            }

            $parts = $this->splitExpression($expression);

            return (string) eval ("return $expression;");

        } catch (InvalidArgumentException $exception) {
            return $exception->getMessage();
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
