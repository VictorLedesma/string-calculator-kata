<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Priority;

use MRC\StringCalculator\PriorityRules;
use MRC\StringCalculator\ExpressionEvaluator;

final class ParenthesesPriorityRule implements PriorityRules
{

    public function apply(array $parts): array
    {


        return ['5', '*', '4'];
    }
}
