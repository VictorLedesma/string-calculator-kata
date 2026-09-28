<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Priority;

use MRC\StringCalculator\OperatorRule;
use MRC\StringCalculator\PriorityRules;
use MRC\StringCalculator\Rules\Operations\AddRule;
use MRC\StringCalculator\Rules\Operations\DivideRule;
use MRC\StringCalculator\Rules\Operations\MultiplyRule;
use MRC\StringCalculator\Rules\Operations\ParenthesesRule;
use MRC\StringCalculator\Rules\Operations\SubtractRule;

final class ExpressionPriorityRule implements PriorityRules
{
    /** @var array<int, array<int, OperatorRule>> */
    private array $operationRules;

    public function __construct(
        private ParenthesesRule $parenthesesRule,
        private MultiplyRule $multiplyRule,
        private DivideRule $divideRule,
        private AddRule $addRule,
        private SubtractRule $subtractRule,
    ) {
        $this->operationRules = [
            [$this->multiplyRule, $this->divideRule],
            [$this->addRule, $this->subtractRule],
        ];
    }

    public function apply(array $parts): array
    {

        $parts = $this->parenthesesRule->calculate($parts);

        foreach ($this->operationRules as $rules) {
            $parts = $this->applyPriorityLevel($parts, $rules);
        }

        return $parts;
    }

    /** @param OperatorRule[] $rules */
    private function applyPriorityLevel(array $parts, array $rules): array
    {
        foreach (array_keys($parts) as $index) {
            if ($index < 1 || $index >= count($parts) - 1) {
                continue;
            }

            $result = $this->calculateOperation(
                array_slice($parts, $index - 1, 3),
                $rules
            );

            if ($result === null) {
                continue;
            }

            array_splice($parts, $index - 1, 3, $result);

            return $this->applyPriorityLevel($parts, $rules);
        }

        return $parts;
    }

    /** @param OperatorRule[] $rules */
    private function calculateOperation(array $parts, array $rules): ?array
    {
        foreach ($rules as $rule) {
            $result = $rule->calculate($parts);

            if ($result !== null) {
                return $result;
            }
        }

        return null;
    }

}
