<?php

declare(strict_types=1);

namespace MRC\StringCalculator;

interface OperatorRule
{
    /** @return string[]|null */
    public function calculate(array $parts): ?array;
}
