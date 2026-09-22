<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\OperatorRule;


final class AddRule implements OperatorRule
{
    public function calculate(array $parts): array
    {
        $result = 0;

        foreach ($parts as $part) {
            if ($part === '+') {
                continue;
            }
            $result += (float) $part;
        }
        return [(string) $result];
    }
}
