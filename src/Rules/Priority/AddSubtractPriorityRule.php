<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Priority;

use MRC\StringCalculator\PriorityRules;


final class AddSubtractPriorityRule implements PriorityRules
{
    public function apply(array $parts): array
    {

        $left = (float) $parts[0];
        $operator = $parts[1];
        $right = (float) $parts[2];

        $result = match ($operator) { '+' => $left + $right};

        return [(string) $result,];
    }


}
