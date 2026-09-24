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

    #[Test]
    public function it_allows_decimals(): void
    {
        $expression = '(2*1.5)/3';
        $expected = '1';

        $result = $this->evaluator->evaluate($expression);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_return_error_when_dividing_by_zero(): void
    {
        $expression = '10/(2-2)';
        $expected = 'Division by zero not allowed';

        $result = $this->evaluator->evaluate($expression);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_return_multiple_errors_expression_case(): void
    {
        $expression = '(10/0)+(5/0)';
        $expected = "Division by zero not allowed\n" . "Division by zero not allowed";

        $result = $this->evaluator->evaluate($expression);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_returns_error_for_invalid_operator(): void
    {
        $expression = '2&3';
        $expected = 'Invalid operator';

        $result = $this->evaluator->evaluate($expression);

        $this->assertSame($expected, $result);
    }
    #[Test]
    public function it_allows_to_multiply_and_divide_in_same_expresion_without_parentheses(): void
    {
        $expression = '2*3/2';
        $expected = '3';

        $result = $this->evaluator->evaluate($expression);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_returns_error_when_expression_has_consecutive_operators(): void
    {
        // Arrange
        $expression = '5*-4';

        $expected = 'Consecutive operators are not allowed';

        // Act
        $result = $this->evaluator->evaluate($expression);

        // Assert
        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_returns_error_when_parentheses_are_invalid(): void
    {
        // Arrange
        $expression = '2(3+4)';

        $expected = 'Invalid parentheses';

        // Act
        $result = $this->evaluator->evaluate($expression);

        // Assert
        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_detects_empty_expression(): void
    {
        // Arrange
        $input = '';

        $expected = 'Expression cannot be empty';

        // Act
        $result = $this->evaluator->evaluate($input);

        // Assert
        $this->assertSame($expected, $result);
    }

}
