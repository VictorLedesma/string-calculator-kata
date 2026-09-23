<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\Operations\SubtractRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SubtractRuleTest extends TestCase
{
    private SubtractRule $rule;

    protected function setUp(): void
    {
        $this->rule = new SubtractRule();
    }

    #[Test]
    public function it_subtract_two_numbers(): void
    {
        $parts = [
            '2',
            '-',
            '1',
        ];
        $expected = ['1'];

        $result = $this->rule->calculate($parts);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_subtract_an_arbitrary_amount_of_numbers(): void
    {
        $parts = [
            '3',
            '-',
            '1',
            '-',
            '1',
        ];
        $expected = ['1'];

        $result = $this->rule->calculate($parts);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_subtracts_to_zero(): void
    {
        $parts = [
            '2',
            '-',
            '2',
        ];

        $expected = [
            '0',
        ];

        $result = $this->rule->calculate($parts);

        $this->assertSame($expected, $result);
    }
}
