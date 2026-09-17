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

        $numbers = str_replace("\n", ',', $numbers);

        $parts = explode(',', $numbers);

        if (count($parts) === 1) {
            return $numbers;
        }

        return (string) array_sum(array_map('floatval', $parts));

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

}

