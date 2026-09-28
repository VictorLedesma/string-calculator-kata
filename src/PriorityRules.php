<?php

declare(strict_types=1);

namespace MRC\StringCalculator;

interface PriorityRules
{
    /** @return string[] */
    public function apply(array $parts): array;
}
