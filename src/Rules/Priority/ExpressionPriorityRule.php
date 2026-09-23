<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Rules\Priority;


class ExpressionPriorityRule
{
    public function __construct(
        private AddRule $addRule,
        private SubtractRule $subtractRule,
        private MultiplyRule $multiplyRule,
        private DivideRule $divideRule,
    ) {
    }

    public function calculate(array $parts): array
    {
        // 1. Buscar la siguiente operación según prioridad
        // 2. Obtener left, operator y right
        // 3. Elegir la OperationRule correspondiente
        // 4. Calcular left y right
        // 5. Sustituir los 3 elementos por el resultado
        // 6. Repetir hasta reducir la expresión
    }
}