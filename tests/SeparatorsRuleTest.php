<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\SeparatorsRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SeparatorsRuleTest extends TestCase
{
    private SeparatorsRule $rule;

    protected function setUp(): void
    {
        $this->rule = new SeparatorsRule();
    }

    #[Test]
    public function it_returns_an_error_when_a_separator_is_followed_by_a_line_break(): void
    {
        $input = "1,\n2";
        $expected = [
            "Error: Invalid input"
        ];

        $result = $this->rule->validate($input);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_returns_an_error_when_separators_are_consecutive(): void
    {
        $input = '1,,2';
        $expected = [
            "Error: Invalid input"
        ];

        $result = $this->rule->validate($input);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_returns_error_when_a_separator_is_at_the_end(): void
    {
        $input = "1,2,";
        $expected = [
            "Error: Invalid input"
        ];

        $result = $this->rule->validate($input);

        $this->assertSame($expected, $result);
    }
}
