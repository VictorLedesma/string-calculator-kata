<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules;

use MRC\StringCalculator\Rule;


final class NegativesRule implements Rule
{
    public function validate(string $input): array
    {
        $errors = [];
        $negatives = [];
        $parts = explode(',', $input);

        foreach ($parts as $part) {
            if ((float) $part < 0) {
                $errors[] = 'Negative not allowed: ' . $part;

            }

        }

        return $errors;
    }
}
