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
            $parts = $this->splitExpression($expression);

            return (string) $this->calculateExpression($parts);

        } catch (InvalidArgumentException $exception) {
            return $exception->getMessage();
        }
    }

    private function calculateExpression(array $parts): float
    {
        $result = (float) $parts[0];

        for ($i = 1; $i < count($parts); $i += 2) {

            $operator = $parts[$i];
            $number = (float) $parts[$i + 1];

            switch ($operator) {

                case '+':
                    $result += $number;
                    break;
                case '-':
                    $result -= $number;
                    break;
                case '*':
                    $result *= $number;
                    break;
                case '/':
                    if ($number === 0.0) {
                        throw new InvalidArgumentException('Division by zero not allowed');
                    }
                default:
                    throw new InvalidArgumentException('Invalid operator');
            }
        }
        return $result;
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
