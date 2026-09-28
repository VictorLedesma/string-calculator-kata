<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\ExpressionEvaluator;
use MRC\StringCalculator\Rules\Priority\ExpressionPriorityRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use MRC\StringCalculator\Rules\Operations\AddRule;
use MRC\StringCalculator\Rules\Operations\DivideRule;
use MRC\StringCalculator\Rules\Operations\MultiplyRule;
use MRC\StringCalculator\Rules\Operations\SubtractRule;
use MRC\StringCalculator\Rules\Operations\ParenthesesRule;


final class ExpressionPriorityRuleTest extends TestCase
{
    private ExpressionPriorityRule $rule;

    protected function setUp(): void
    {
        $evaluator = new ExpressionEvaluator();

        $this->rule = new ExpressionPriorityRule(
            new ParenthesesRule($evaluator),
            new MultiplyRule(),
            new DivideRule(),
            new AddRule(),
            new SubtractRule(),
        );

    }
    #[Test]
    public function it_resolves_expression_using_operation_rules(): void
    {
        // Arrange
        $parts = [
            '10',
            '-',
            '5',
            '-',
            '2',
        ];

        $expected = [
            '3',
        ];

        // Act
        $result = $this->rule->apply($parts);

        // Assert
        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_resolves_expression_with_priority(): void
    {
        $parts = [
            '10',
            '-',
            '2',
            '*',
            '4',
        ];

        $expected = [
            '2',
        ];

        $result = $this->rule->apply($parts);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_resolves_parentheses_before_other_operations(): void
    {
        $parts = [
            '(',
            '2',
            '+',
            '3',
            ')',
            '*',
            '4',
        ];
        $expected = [
            '20',
        ];

        $result = $this->rule->apply($parts);

        $this->assertSame($expected, $result);
    }
    #[Test]
    public function it_resolves_parentheses_inside_parentheses(): void
    {
        // Arrange
        $parts = [
            '(',
            '(',
            '5',
            '*',
            '4',
            ')',
            '/',
            '(',
            '5',
            '*',
            '2',
            ')',
            ')',
            '+',
            '10',
        ];

        $expected = [
            '12',
        ];

        // Act
        $result = $this->rule->apply($parts);

        // Assert
        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_resolves_parentheses_with_priority_inside(): void
    {
        $parts = [
            '(',
            '2',
            '+',
            '3',
            '*',
            '4',
            ')',
        ];

        $expected = [
            '14',
        ];

        $result = $this->rule->apply($parts);

        $this->assertSame($expected, $result);
    }

}
