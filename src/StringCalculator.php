<?php

declare(strict_types=1);

namespace MRC\StringCalculator;

use InvalidArgumentException;
use function PHPUnit\Framework\throwException;

final class StringCalculator
{
    public function add(string $numbers): string
    {
        return $this->calculate($numbers, fn(array $numbers) => array_sum($numbers));
    }

    public function multiply(string $numbers): string
    {
        return $this->calculate($numbers, fn(array $numbers) => array_product($numbers));
    }

    public function divide(string $numbers): string
    {
        return $this->calculate($numbers, fn(array $numbers) => $this->divideNumbers($numbers));
    }

    private function calculate(string $numbers, callable $operation): string
    {
        try {
            if ($this->isEmpty($numbers)) {
                return '0';
            }

            $this->validateMultipleErrorsInOrder($numbers);

            $this->validateSeparators($numbers);

            $numbers = $this->normalizeSeparators($numbers);
            $parts = $this->splitNumbers($numbers);

            $this->validateNegativeNumbers($parts);

            $values = array_map('floatval', $parts);

            return (string) $operation($values);

        } catch (InvalidArgumentException $exception) {
            return $exception->getMessage();
        }
    }

    public function validateSeparators(string $number): void
    {
        $invalidPosition = strpos($number, ",,");

        if ($invalidPosition !== false) {
            throw new InvalidArgumentException("Number expected but ',' found at position" . ($invalidPosition + 1));
        }

        $invalidPosition = strpos($number, ",\n");

        if ($invalidPosition !== false) {
            throw new InvalidArgumentException('Error: Invalid input');
        }

        if (str_ends_with($number, ',')) {
            throw new InvalidArgumentException('Error: Invalid input');
        }

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

    private function validateNegativeNumbers(array $parts): void
    {
        $negatives = [];

        foreach ($parts as $part) {
            if ((float) $part < 0) {
                $negatives[] = $part;
            }
        }

        if (!empty($negatives)) {
            throw new InvalidArgumentException("Negative not allowed: " . implode(', ', $negatives));
        }

    }

    private function splitNumbers(string $numbers): array
    {
        return explode(',', $numbers);
    }

    private function validateMultipleErrorsInOrder(string $numbers): void
    {
        if (strpos($numbers, ',,') === false) {
            return;
        }

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

        throw new InvalidArgumentException(implode("\n", $errors));

    }

    private function divideNumbers(array $numbers): float
    {
        $result = $numbers[0];

        foreach (array_slice($numbers, 1) as $number) {

            if ($number === 0.0) {
                throw new InvalidArgumentException('Division by zero not allowed');
            }

            $result /= $number;
        }

        return $result;
    }
}

