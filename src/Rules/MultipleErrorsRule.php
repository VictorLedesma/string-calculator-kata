<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules;

use MRC\StringCalculator\Rule;


final class MultipleErrorsRule implements Rule
{
    private array $rules;

    public function __construct()
    {
        $this->rules = [
            new NegativesRule(),
            new SeparatorsRule(),
        ];
    }

    public function validate(string $input): array
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            foreach ($rule->validate($input) as $error) {
                $errors[] = [
                    'message' => $error,
                    'position' => $this->getErrorPosition($input, $error),
                ];
            }
        }

        usort(
            $errors,
            fn(array $first, array $second) =>
                $first['position'] <=> $second['position']
        );

        return array_column($errors, 'message');
    }

    private function getErrorPosition(string $input, string $error): int
    {
        if (str_starts_with($error, 'Negative not allowed: ')) {
            $number = substr($error, strlen('Negative not allowed: '));

            return strpos($input, $number);
        }

        if (str_starts_with($error, "Number expected but ',' found at position ")) {
            preg_match('/position (\d+)/', $error, $matches);

            return (int) $matches[1];
        }

        return PHP_INT_MAX;
    }
}
