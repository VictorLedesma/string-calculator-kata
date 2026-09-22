<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\OperatorRule;


final class AddRule implements OperatorRule
{
    public function calculate(array $parts): array
    {
        $left = (float) $parts[0];
        $right = (float) $parts[2];

        return [(string) ($left + $right)];
    }
}
