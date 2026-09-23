<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;


use MRC\StringCalculator\Rules\Priority\AddSubtractPriorityRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class AddSubtractPriorityRuleTest extends TestCase
{
    private AddSubtractPriorityRule $rule;

    protected function setUp(): void
    {
        $this->rule = new AddSubtractPriorityRule();
    }

    #[Test]
    public function it_resolves_addition_priority(): void
    {
        $parts = [
            '4',
            '+',
            '2',
        ];
        $expected = [
            '6',
        ];

        $result = $this->rule->apply($parts);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_resolves_subtraction_priority(): void
    {
        $parts = [
            '4',
            '-',
            '2',
        ];
        $expected = [
            '2',
        ];

        $result = $this->rule->apply($parts);

        $this->assertSame($expected, $result);
    }

}
