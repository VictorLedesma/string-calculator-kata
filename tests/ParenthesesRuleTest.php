<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\Operations\ParenthesesRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ParenthesesRuleTest extends TestCase
{
    private ParenthesesRule $rule;

    protected function setUp(): void
    {
        $this->rule = new ParenthesesRule();
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

        $result = $this->rule->calculate($parts);

        $this->assertSame($expected, $result);
    }
}
