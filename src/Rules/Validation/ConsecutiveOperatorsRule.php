<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Validation;

use MRC\StringCalculator\Rule;

final class ConsecutiveOperatorsRule implements Rule
{
    public function validate(string $input): array
    {
        if (preg_match('/[+\-*\/]{2,}/', $input)) {
            return [
                'Consecutive operators are not allowed',
            ];
        }

        return [];
    }
}
