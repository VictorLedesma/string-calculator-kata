<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Operations;

use MRC\StringCalculator\OperatorRule;
use MRC\StringCalculator\ExpressionEvaluator;
use InvalidArgumentException;


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
            $closePosition = $this->findClosingPosition($parts, $openPosition);

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
                [$result[0]]
            );
        }

        return $parts;
    }

    private function findClosingPosition(array $parts, int $openPosition): int
    {
        $level = 0;

        for ($position = $openPosition; $position < count($parts); $position++) {

            if ($parts[$position] === '(') {
                $level++;
            }

            if ($parts[$position] === ')') {
                $level--;

                if ($level === 0) {
                    return $position;
                }
            }
        }

        throw new InvalidArgumentException('Invalid parentheses');
    }
}
