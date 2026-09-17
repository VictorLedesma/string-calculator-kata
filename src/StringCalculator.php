<?php

declare(strict_types=1);

namespace MRC\StringCalculator;

final class StringCalculator
{
    public function add(string $numbers): string
    {
        if ($this->isEmpty($numbers)) {
            return '0';
        }

        $error = $this->validateSeparators($numbers);

        if ($error !== null) {
            return $error;
        }

        $numbers = $this->normalizeSeparators($numbers);

        $parts = explode(',', $numbers);

        return $this->calculateSum($parts);

    }

    public function validateSeparators(string $number): ?string
    {
        $invalidPosition = strpos($number, ",\n");
        if ($invalidPosition !== false) {
            return 'Error: Invalid input';
        }

        if (str_ends_with($number, ',')) {
            return 'Error: Invalid input';
        }

        return null;

    }

    private function isEmpty(string $number): bool
    {
        return $number === '';
    }

    private function normalizeSeparators(string $number): string
    {
        if (str_starts_with($number, "//")) {

            $separatorEnd = strpos($number, "\n");
            $separator = substr($number, 2, $separatorEnd - 2);

            $number = substr($number, $separatorEnd + 1);

            return str_replace($separator, ',', $number);
        }

        return str_replace("\n", ',', $number);
    }

    private function calculateSum(array $parts): string
    {
        if (count($parts) === 1) {
            return $parts[0];
        }

        return (string) array_sum(array_map('floatval', $parts));
    }

}

