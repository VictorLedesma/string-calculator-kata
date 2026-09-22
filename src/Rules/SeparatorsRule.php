<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules;

use MRC\StringCalculator\Rule;


final class SeparatorsRule implements Rule
{
    public function validate(string $input): array
    {
        $errors = [];

        $invalidPosition = strpos($input, ",\n");

        if ($invalidPosition !== false) {
            $errors[] = "Error: Invalid input";
        }

        $invalidPosition = strpos($input, ",,");

        if ($invalidPosition !== false) {
            $errors[] = "Error: Invalid input";
        }

        if (str_ends_with($input, ",")) {
            $errors[] = "Error: Invalid input";
        }

        return $errors;
    }
}
