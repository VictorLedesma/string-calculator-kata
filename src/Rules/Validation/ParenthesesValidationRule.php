<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Validation;

use MRC\StringCalculator\Rule;

final class ParenthesesValidationRule implements Rule
{
    public function validate(string $input): array
    {
        return [];
    }
}
