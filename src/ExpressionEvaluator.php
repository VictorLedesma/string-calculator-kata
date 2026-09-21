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
        $result = [];

        $i = 0;

        while ($i < count($parts)) {
            if (isset($parts[$i + 1], $parts[$i + 2]) && (($parts[$i + 1] === '*' || $parts[$i + 1] === '/'))) {
                $left = (float) $parts[$i];
                $operator = $parts[$i + 1];
                $right = (float) $parts[$i + 2];

                if ($operator === '*') {
                    $value = $left * $right;

                } else {
                    if ($right === 0.0) {
                        throw new InvalidArgumentException('Division by zero not allowed');
                    }
                    $value = $left / $right;
                }
                $result[] = (string) $value;
                $i += 3;
                continue;
            }

            $result[] = $parts[$i];
            $i++;
        }
        return $result;
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

            throw new InvalidArgumentException('Invalid operator');
        }
        return $result;
    }

}
