<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\Priority\ParenthesesPriorityRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ParenthesesPriorityRuleTest extends TestCase
{
    private ParenthesesPriorityRule $rule;

    protected function setUp(): void
    {
        $this->rule = new ParenthesesPriorityRule();
    }

    #[Test]
    public function it_resolves_parentheses(): void
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
            '5',
            '*',
            '4',
        ];

        $result = $this->rule->apply($parts);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_resolves_different_parentheses_expression(): void
    {
        $parts = [
            '(',
            '4',
            '+',
            '6',
            ')',
            '*',
            '2',
        ];
        $expected = [
            '10',
            '*',
            '2',
        ];

        $result = $this->rule->apply($parts);

        $this->assertSame($expected, $result);
    }


}
