<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\Priority\ExpressionPriorityRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use MRC\StringCalculator\Rules\Operations\AddRule;
use MRC\StringCalculator\Rules\Operations\DivideRule;
use MRC\StringCalculator\Rules\Operations\MultiplyRule;
use MRC\StringCalculator\Rules\Operations\SubtractRule;


final class ExpressionPriorityRuleTest extends TestCase
{
    private ExpressionPriorityRule $rule;

    protected function setUp(): void
    {
        $this->rule = new ExpressionPriorityRule(
            new AddRule(),
            new SubtractRule(),
            new MultiplyRule(),
            new DivideRule(),
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
}
