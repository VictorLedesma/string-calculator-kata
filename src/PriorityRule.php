<?php

declare(strict_types=1);

namespace MRC\StringCalculator;


interface PriorityRule
{
    /** @return string[] */
    public function operator(): string;

    public function calculate(float $left, float $right): float;
}