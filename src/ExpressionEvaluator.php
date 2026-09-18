<?php

declare(strict_types=1);

namespace MRC\StringCalculator;

final class ExpressionEvaluator
{
    public function evaluate(string $expression): string
    {
        return (string) eval ("return $expression;");
    }
}
