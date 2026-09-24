<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Validation;

use MRC\StringCalculator\Rule;

final class ParenthesesValidationRule implements Rule
{
    public function validate(string $input): array
    {
        if (substr_count($input, '(') !== substr_count($input, ')')) {
            return ['Invalid parentheses'];
        }

        if (str_contains($input, '()')) {
            return ['Invalid parentheses'];
        }

        if (preg_match('/\d\(/', $input)) {
            return ['Invalid parentheses'];
        }

        if (preg_match('/\)\d/', $input)) {
            return ['Invalid parentheses'];
        }

        return [];
    }

}
