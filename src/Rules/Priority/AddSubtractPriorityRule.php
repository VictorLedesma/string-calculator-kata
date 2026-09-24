<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Priority;

use MRC\StringCalculator\PriorityRules;


final class AddSubtractPriorityRule implements PriorityRules
{
    public function apply(array $parts): array
    {
        foreach ($parts as $index => $part) {

            if ($part !== '+' && $part !== '-') {
                continue;
            }

            $left = (float) $parts[$index - 1];
            $right = (float) $parts[$index + 1];

            $result = match ($part) {
                '+' => $left + $right,
                '-' => $left - $right,
            };

            array_splice(
                $parts,
                $index - 1,
                3,
                [(string) $result]
            );
            break;
        }
        return $parts;
    }

}
