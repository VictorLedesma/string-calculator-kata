<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\OperatorRule;


final class MultiplyRule implements OperatorRule
{
    public function calculate(array $parts): array
    {
        $operatorPosition = $this->findMultiplicationOperator($parts);

        while ($operatorPosition !== null) {
            $left = (float) $parts[$operatorPosition - 1];
            $right = (float) $parts[$operatorPosition + 1];

            $result = $left * $right;

            array_splice(
                $parts,
                $operatorPosition - 1,
                3,
                [(string) $result]
            );

            $operatorPosition = $this->findMultiplicationOperator($parts);
        }

        return $parts;
    }

    private function findMultiplicationOperator(array $parts): ?int
    {
        foreach ($parts as $position => $part) {
            if ($part === '*') {
                return $position;
            }
        }

        return null;
    }
}
