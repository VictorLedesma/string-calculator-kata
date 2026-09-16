<?php

declare(strict_types=1);

namespace MRC\StringCalculator;

final class StringCalculator
{
    public function add(string $numbers): string
    {
        if ($numbers === "") {
            return '0';
        }
        $invalidPosition = strpos($numbers, ",\n");

        if ($invalidPosition !== false) {
            return 'Error: Invalid input';
        }
        $numbers = str_replace("\n", ',', $numbers);

        $parts = explode(',', $numbers);

        if (count($parts) === 1) {
            return $numbers;
        }

        return (string) array_sum(array_map('floatval', $parts));

    }

}

