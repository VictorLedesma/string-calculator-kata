<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Priority;

use MRC\StringCalculator\PriorityRules;
use MRC\StringCalculator\Rules\Operations\AddRule;
use MRC\StringCalculator\Rules\Operations\DivideRule;
use MRC\StringCalculator\Rules\Operations\MultiplyRule;
use MRC\StringCalculator\Rules\Operations\SubtractRule;



// 1. Buscar la siguiente operación según prioridad
// 2. Obtener left, operator y right
// 3. Elegir la OperationRule correspondiente
// 4. Calcular left y right
// 5. Sustituir los 3 elementos por el resultado
// 6. Repetir hasta reducir la expresión
final class ExpressionPriorityRule implements PriorityRules
{
    public function __construct(
        private AddRule $addRule,
        private SubtractRule $subtractRule,
        private MultiplyRule $multiplyRule,
        private DivideRule $divideRule,
    ) {
    }

    public function apply(array $parts): array
    {
        $operation = $this->findOperation($parts);

        if ($operation === null) {
            return $parts;
        }

        $result = $this->calculateOperation(
            $operation['left'],
            $operation['operator'],
            $operation['right']
        );

        array_splice(
            $parts,
            $operation['index'],
            3,
            $result
        );

        return $this->apply($parts);
    }

    private function findOperation(array $parts): ?array
    {
        $levels = [
            ['*', '/'],
            ['+', '-'],
        ];

        foreach ($levels as $level) {
            foreach ($parts as $index => $part) {

                if (in_array($part, $level, true)) {
                    return [
                        'index' => $index - 1,
                        'left' => $parts[$index - 1],
                        'operator' => $parts[$index],
                        'right' => $parts[$index + 1],
                    ];
                }
            }
        }

        return null;
    }

    private function calculateOperation(string $left, string $operator, string $right): array
    {

        $rule = match ($operator) {
            '+' => $this->addRule,
            '-' => $this->subtractRule,
            '*' => $this->multiplyRule,
            '/' => $this->divideRule,
        };

        return $rule->calculate([$left, $operator, $right,]);
    }
}
