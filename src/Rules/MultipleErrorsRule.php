<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules;

use MRC\StringCalculator\Rule;


final class MultipleErrorsRule implements Rule
{
    public function validate(string $input): array
    {
        return [];

    }
}
