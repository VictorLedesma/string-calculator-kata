<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\ExpressionEvaluator;
use MRC\StringCalculator\OperatorRule;

final class DivideRule implements OperatorRule
{
    public function __construct(
        private ?ExpressionEvaluator $evaluator = null
    ) {
    }

    public function calculate(array $parts): array
    {
        $left = (float) $parts[0];
        $right = (float) $parts[2];

        if ($right === 0.0) {
            $this->evaluator?->addError(
                'Division by zero not allowed'
            );

            return ['0'];
        }
        return [(string) ($left / $right),];
    }
}
