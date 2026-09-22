<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\OperatorRule;
use MRC\StringCalculator\ExpressionEvaluator;


final class ParenthesesRule implements OperatorRule
{
    private ExpressionEvaluator $evaluator;

    public function __construct(ExpressionEvaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }
    public function calculate(array $parts): array
    {
        while (in_array('(', $parts, true)) {

            $openPosition = array_search('(', $parts, true);
            $closePosition = array_search(')', $parts, true);

            $inside = array_slice(
                $parts,
                $openPosition + 1,
                $closePosition - $openPosition - 1
            );

            $result = $this->evaluator->calculateExpression($inside);

            array_splice(
                $parts,
                $openPosition,
                $closePosition - $openPosition + 1,
                [(string) $result]
            );
        }

        return $parts;
    }
}
