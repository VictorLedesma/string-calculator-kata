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

    #[Test]
    public function it_returns_error_when_expression_divides_by_zero_evaluator_case(): void
    {
        $expression = '10/0';
        $expected = 'Division by zero not allowed';

        $result = $this->evaluator->evaluate($expression);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_evaluates_addition_expression(): void
    {
        $expression = '2+3';
        $expected = '5';

        $result = $this->evaluator->evaluate($expression);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_respect_operator_precedence(): void
    {
        $expression = '2+3*4';
        $expected = '14';

        $result = $this->evaluator->evaluate($expression);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_respect_parenthesis_priority(): void
    {
        $expression = '(2+2)/4';
        $expected = '1';

        $result = $this->evaluator->evaluate($expression);

        $this->assertSame($expected, $result);
    }
}
