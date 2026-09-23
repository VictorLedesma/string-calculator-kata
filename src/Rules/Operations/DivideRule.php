<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\ExpressionEvaluator;
use MRC\StringCalculator\OperatorRule;
use MRC\StringCalculator\Rules\Validation\DivisionByZeroRule;

final class DivideRule implements OperatorRule
{
    private DivisionByZeroRule $divisionByZeroRule;
    private ?ExpressionEvaluator $evaluator;

    public function __construct(?ExpressionEvaluator $evaluator = null, ?DivisionByZeroRule $divisionByZeroRule = null)
    {
        $this->divisionByZeroRule = $divisionByZeroRule ?? new DivisionByZeroRule();
        $this->evaluator = $evaluator;
    }

    public function calculate(array $parts): array
    {
        $errors = $this->divisionByZeroRule->validate(implode('', $parts));

        foreach ($errors as $error) {
            if ($this->evaluator !== null) {
                $this->evaluator->addError($error);
            }
        }

        $operatorPosition = $this->findDivisionOperator($parts);

        for (; $operatorPosition !== null; $operatorPosition = $this->findDivisionOperator($parts)) {
            $left = (float) $parts[$operatorPosition - 1];
            $right = (float) $parts[$operatorPosition + 1];

            if ($right === 0.0) {
                array_splice(
                    $parts,
                    $operatorPosition - 1,
                    3,
                    ['0']
                );

                continue;
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
