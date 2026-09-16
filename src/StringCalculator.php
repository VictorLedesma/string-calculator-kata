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

        $parts = explode(',', $numbers);

        if (count($parts) === 1) {
            return $numbers;
        }

        return (string) array_sum(array_map('floatval', $parts));

    }

}

