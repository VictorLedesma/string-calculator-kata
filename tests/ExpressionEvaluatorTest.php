<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\ExpressionEvaluator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ExpressionEvaluatorTest extends TestCase
{
    private ExpressionEvaluator $evaluator;

    protected function setUp(): void
    {
        $this->evaluator = new ExpressionEvaluator();
    }

    #[Test]
    public function it_evaluates_a_simple_expression(): void
    {
        $expression = '2*3+4';
        $expected = '10';

        $result = $this->evaluator->evaluate($expression);

        $this->assertSame($expected, $result);
    }
}
