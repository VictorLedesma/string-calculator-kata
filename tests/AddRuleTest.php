<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\Operations\AddRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class AddRuleTest extends TestCase
{
    private AddRule $rule;

    protected function setUp(): void
    {
        $this->rule = new AddRule();
    }

    #[Test]
    public function it_adds_two_numbers(): void
    {
        $parts = [
            '1',
            '+',
            '2',
        ];

        $expected = [
            '3',
        ];

        $result = $this->rule->calculate($parts);

        $this->assertSame($expected, $result);
    }
}
