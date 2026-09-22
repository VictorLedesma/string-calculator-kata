<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\MultipleErrorsRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MultipleErrorsRuleTest extends TestCase
{
    private MultipleErrorsRule $rule;

    protected function setUp(): void
    {
        $this->rule = new MultipleErrorsRule();
    }

    #[Test]
    public function it_returns_multiple_errors_in_their_original_order(): void
    {
        $input = '-1,,-2';
        $expected = [
            'Negative not allowed: -1',
            "Number expected but ',' found at position 3",
            'Negative not allowed: -2'
        ];

        $result = $this->rule->validate($input);

        $this->assertEquals($expected, $result);
    }

    #[Test]
    public function it_returns_multiple_errors_in_their_original_order_switch_case(): void
    {
        $input = ',,-1,-2';
        $expected = [
            "Number expected but ',' found at position 1",
            'Negative not allowed: -1',
            'Negative not allowed: -2'
        ];

        $result = $this->rule->validate($input);

        $this->assertEquals($expected, $result);
    }

}
