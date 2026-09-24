<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\OperatorRule;


final class AddRule implements OperatorRule
{
    public function calculate(array $parts): array
    {
        return [(string) ((float) $parts[0] + (float) $parts[2])];
    }

}
