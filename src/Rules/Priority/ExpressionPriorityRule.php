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
class ExpressionPriorityRule implements PriorityRules
{
    /*public function __construct(
        private AddRule $addRule,
        private SubtractRule $subtractRule,
        private MultiplyRule $multiplyRule,
        private DivideRule $divideRule,
    ) {
    }*/

    public function apply(array $parts): array
    {

        foreach (['*', '/', '+', '-'] as $operator) {

            $index = array_search($operator, $parts, true);

            if ($index !== false) {
                return [
                    $parts[$index - 1],
                    $parts[$index],
                    $parts[$index + 1],
                ];
            }
        }

        return $parts;
    }

}
