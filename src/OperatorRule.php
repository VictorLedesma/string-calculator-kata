<?php

declare(strict_types=1);

namespace MRC\StringCalculator;

interface OperatorRule
{
    /** @return string[] */
    public function calculate(string $input): float;
}
