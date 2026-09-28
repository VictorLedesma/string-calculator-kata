<?php

declare(strict_types=1);

namespace MRC\StringCalculator;

interface Rule
{
    /** @return string[] */
    public function validate(string $input): array;
}
