<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\OperatorRule;


final class SubtractRule implements OperatorRule
{
    public function calculate(array $parts): array
    {
        $result = (float) $parts[0];

        foreach ($parts as $part) {
            if ($part === $parts[0] || $part === '-') {
                continue;
            }

            $result -= (float) $part;
        }

        return [(string) $result];
    }
}
