<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\OperatorRule;


final class MultiplyRule implements OperatorRule
{
    public function calculate(array $parts): array
    {
        $result = 0;
        return [(string) $result];
    }
}
