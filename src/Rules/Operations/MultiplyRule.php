<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\OperatorRule;


final class MultiplyRule implements OperatorRule
{
    public function calculate(array $parts): ?array
    {
        if (($parts[1] ?? null) !== '*') {
            return null;
        }

        return [(string) ((float) $parts[0] * (float) $parts[2])];
    }

}
