<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Validation;

use MRC\StringCalculator\Rule;


final class EmptyExpressionRule implements Rule
{
    public function validate(string $input): array
    {
        if ($input === "") {
            return ['Expression cannot be empty'];
        }
        return [];
    }
}
