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

        $parts = $this-> splitNumbers($numbers);

        $error = $this->validateNegativeNumbers($parts);

        if ($error !== null) {
            return $error;
        }

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
            [$separator, $number] = $this->extractCustomSeparator($number);

            return str_replace($separator, ',', $number);
        }

        return str_replace("\n", ',', $number);
    }

    private function extractCustomSeparator(string $number): array
    {
        $separatorEnd = strpos($number, "\n");
        //\n\n

        $separator = substr($number, 2, $separatorEnd - 2);
        $number = substr($number, $separatorEnd + 1);

        return [$separator, $number];
    }

    private function calculateSum(array $parts): string
    {
        if (count($parts) === 1) {
            return $parts[0];
        }

        return (string) array_sum(array_map('floatval', $parts));
    }

    private function validateNegativeNumbers(array $parts): ?string
    {
        $negatives = [];

        foreach ($parts as $part) {
            if ((float) $part < 0) {
                $negatives[] = $part;
            }
        }

        if (!empty($negatives)) {
            return "Error: Negative numbers are not allowed: " . implode(', ', $negatives);
        }

        return null;
    }

    private function splitNumbers(string $numbers): array
    {
        return explode(',', $numbers);
    }

}

