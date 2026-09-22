<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\Operations\DivideRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class DivideRuleTest extends TestCase
{
    private DivideRule $rule;

    protected function setUp(): void
    {
        $this->rule = new DivideRule();
    }

    #[Test]
    public function it_divides_two_numbers(): void
    {
        $parts = [
            '10',
            '/',
            '2',
        ];
        $expected = ['5',];

        $result = $this->rule->calculate($parts);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_divides_an_arbitrary_amount_of_numbers(): void
    {
        $parts = [
            '20',
            '/',
            '2',
            '/',
            '2',
        ];
        $expected = ['5',];

        $result = $this->rule->calculate($parts);

        $this->assertSame($expected, $result);
    }
}
