<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules;

use MRC\StringCalculator\Rule;


final class MultipleErrorsRule implements Rule
{
    public function validate(string $input): array
    {
        $errors = [];
        $parts = explode(',', $input);
        $position = 0;

        foreach ($parts as $part) {
            if ((float) $part < 0) {
                $errors[] = 'Negative not allowed: ' . $part;
            }

            if ($part === '') {
                $errors[] = "Error: Invalid input";

            }

            $position += strlen($part) + 1;

        }
        return $errors;
    }
}
