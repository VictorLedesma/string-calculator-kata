<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules;

use MRC\StringCalculator\Rule;


final class InvalidCharacterRule implements Rule
{
    private const OPERATORS = [
        '+',
        '-',
        '*',
        '/',
        '(',
        ')',
    ];

    public function validate(string $input): array
    {
        $errors = [];

        foreach (str_split($input) as $character) {
            if (
                !$this->isValidCharacter($character)
            ) {
                $errors[] = 'Invalid operator';
            }
        }

        return $errors;
    }

    private function isValidCharacter(string $character): bool
    {
        return in_array($character, self::OPERATORS, true) || is_numeric($character) || $character === '.';
    }
}
