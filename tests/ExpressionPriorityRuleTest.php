<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\Priority\ExpressionPriorityRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ExpressionPriorityRuleTest extends TestCase
{
    private ExpressionPriorityRule $rule;

    protected function setUp(): void
    {
        $this->rule = new ExpressionPriorityRule();
    }

    #[Test]
    public function it_finds_the_first_operation_to_resolve(): void
    {
        $parts = [
            '10',
            '-',
            '5',
            '-',
            '2',
        ];
        $expected = [
            '10',
            '-',
            '5',
        ];

        $result = $this->rule->apply($parts);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_prioritizes_multiplication_over_addition(): void
    {
        $parts = [
            '4',
            '+',
            '2',
            '*',
            '3',
        ];
        $expected = [
            '2',
            '*',
            '3',
        ];

        $result = $this->rule->apply($parts);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_resolves_same_priority_operations_from_left_to_right(): void
    {
        $parts = [
            '10',
            '/',
            '2',
            '*',
            '5',
        ];
        $expected = [
            '10',
            '/',
            '2',
        ];

        $result = $this->rule->apply($parts);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_returns_expression_when_there_is_no_operation(): void
    {
        $parts = [
            '5',
        ];
        $expected = [
            '5',
        ];

        $result = $this->rule->apply($parts);

        $this->assertSame($expected, $result);
    }
}
