<?php

declare(strict_types=1);

namespace MRC\StringCalculator;

use InvalidArgumentException;

final class ExpressionEvaluator
{
    public function evaluate(string $expression): string
    {
        try {

            if (str_contains($expression, '/0')) {
                throw new InvalidArgumentException('Division by zero not allowed');
            }

            $expression = $this->splitExpression($expression);

            return (string) eval ("return $expression;");

        } catch (InvalidArgumentException $exception) {
            return $exception->getMessage();
        }
    }

    private function splitExpression(string $expression): string
    {
        return $expression;
    }
}
