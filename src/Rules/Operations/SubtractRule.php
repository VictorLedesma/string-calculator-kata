<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\OperatorRule;


final class SubtractRule implements OperatorRule
{
    public function calculate(array $parts): array
    {
        if (!in_array('-', $parts, true)) {
            return $parts;
        }

        $result = (float) $parts[0];

        for ($i = 1; $i < count($parts); $i++) {

            if ($parts[$i] === '-') {
                continue;
            }

            $result -= (float) $parts[$i];
        }

        return [
            (string) $result
        ];
    }
}
