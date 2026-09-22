<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\OperatorRule;


final class DivideRule implements OperatorRule
{
    public function calculate(array $parts): array
    {
        $result = 1;

        return [(string) $result];
    }
}
