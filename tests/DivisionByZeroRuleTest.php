<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\DivisionByZeroRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class DivisionByZeroRuleTest extends TestCase
{
    private DivisionByZeroRule $rule;

    protected function setUp(): void
    {
        $this->rule = new DivisionByZeroRule();
    }

    #[Test]
    public function it_returns_error_when_dividing_by_zero_rule(): void
    {
        $input = '10/(2-2)';
        $expected = 'Division by zero not allowed';

        $result = $this->rule->validate($input);

        $this->assertSame($expected, $result);
    }
}
