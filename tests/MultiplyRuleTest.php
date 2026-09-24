<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\Operations\MultiplyRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MultiplyRuleTest extends TestCase
{
    private MultiplyRule $rule;

    protected function setUp(): void
    {
        $this->rule = new MultiplyRule();
    }

    #[Test]
    public function it_multiplies_two_numbers(): void
    {
        $parts = [
            '2',
            '*',
            '2',
        ];

        $expected = [
            '4',
        ];

        $result = $this->rule->calculate($parts);

        $this->assertSame($expected, $result);
    }

}
