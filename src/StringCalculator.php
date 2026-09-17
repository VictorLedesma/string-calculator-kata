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

        if (strpos($numbers, ',,') !== false) {
            $errors = [];
            $parts = explode(',', $numbers);
            $position = 0;

            foreach ($parts as $part) {

                if ((float) $part < 0) {
                    $errors[] = 'Negative not allowed: ' . $part;
                }

                if ($part === '') {
                    $errors[] = "Number expected but ',' found at position " . $position;
                }

                $position += strlen($part) + 1;

            }

            return implode("\n", $errors);

        }

        $separatorError = $this->validateSeparators($numbers);

        $numbers = $this->normalizeSeparators($numbers);

        $parts = $this->splitNumbers($numbers);

        $negativeError = $this->validateNegativeNumbers($parts);

        if ($negativeError !== null) {
            $errors[] = $negativeError;
        }

        if ($separatorError !== null) {
            $errors[] = $separatorError;
        }

        if (!empty($errors)) {
            return implode("\n", $errors);
        }

        return $this->calculateSum($parts);

    }

    public function validateSeparators(string $number): ?string
    {
        $invalidPosition = strpos($number, ",,");

        if ($invalidPosition !== false) {
            return "Number expected but ',' found at position " . ($invalidPosition + 1);
        }

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
            return "Negative not allowed: " . implode(', ', $negatives);
        }

        return null;
    }

    private function splitNumbers(string $numbers): array
    {
        return explode(',', $numbers);
    }

}

