<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Priority;

use MRC\StringCalculator\PriorityRules;
use MRC\StringCalculator\ExpressionEvaluator;

final class ParenthesesPriorityRule implements PriorityRules
{
    public function apply(array $parts): array
    {
        $number1 = (int) $parts[1];
        $operator = $parts[2];
        $number2 = (int) $parts[3];

        $result = match ($operator) { '+' => $number1 + $number2};

        return [
            (string) $result,
            ...array_slice($parts, 5),
        ];
    }
}
