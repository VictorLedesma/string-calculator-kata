<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules;

use MRC\StringCalculator\Rule;

final class DivisionByZeroRule implements Rule
{
    public function validate(string $input): array
    {
        $errors = [];
        $parts = str_split($input);

        for ($i = 0; $i < count($parts) - 1; $i++) {
            if ($parts[$i] === '/' && (float) $parts[$i + 1] === 0.0) {
                $errors[] = 'Division by zero not allowed';
            }
        }

        return $errors;

    }

}
