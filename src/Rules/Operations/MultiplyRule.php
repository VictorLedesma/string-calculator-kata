<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\OperatorRule;


final class MultiplyRule implements OperatorRule
{
    public function calculate(array $parts): array
    {
        $result = 1;

        foreach ($parts as $part) {
            if ($part === '*') {
                continue;
            }
            $result *= (float) $part;
        }

        return [(string) $result];
    }
}
