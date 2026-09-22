<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\OperatorRule;
use InvalidArgumentException;


final class DivideRule implements OperatorRule
{
    public function calculate(array $parts): array
    {
        while (($operatorPosition = $this->findDivisionOperator($parts)) !== null) {

            $left = (float) $parts[$operatorPosition - 1];
            $right = (float) $parts[$operatorPosition + 1];

            if ($right === 0.0) {
                throw new InvalidArgumentException(
                    'Division by zero not allowed'
                );
            }

            $result = $left / $right;

            array_splice(
                $parts,
                $operatorPosition - 1,
                3,
                [(string) $result]
            );
        }

        return $parts;
    }

    private function findDivisionOperator(array $parts): ?int
    {
        foreach ($parts as $position => $part) {
            if ($part === '/') {
                return $position;
            }
        }

        return null;
    }
}
