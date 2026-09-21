<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\InvalidCharacterRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;


final class InvalidCharacterRuleTest extends TestCase
{
    private InvalidCharacterRule $rule;

    protected function setUp(): void
    {
        $this->rule = new InvalidCharacterRule();
    }

    #[Test]
    public function it_returns_an_error_for_an_invalid_character(): void
    {
        $input = '2&3';
        $expected = ['Invalid operator',];

        $result = $this->rule->validate($input);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_returns_all_invalid_character_errors(): void
    {
        $input = '2&3@4';
        $expected = [
            "Invalid operator",
            "Invalid operator"
        ];

        $result = $this->rule->validate($input);

        $this->assertSame($expected, $result);
    }
}
