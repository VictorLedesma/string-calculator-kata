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
            $errors[] = "Number expected but ',' found at position " . ($invalidPosition + 1);
        }

        return $errors;
    }
}
