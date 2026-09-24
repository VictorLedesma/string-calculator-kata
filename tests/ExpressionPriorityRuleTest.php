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
}
