<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\Validation\ConsecutiveOperatorsRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ConsecutiveOperatorsRuleTest extends TestCase
{
    private ConsecutiveOperatorsRule $rule;

    protected function setUp(): void
    {
        $this->rule = new ConsecutiveOperatorsRule();
    }

    #[Test]
    public function it_detects_consecutive_operators(): void
    {
        // Arrange
        $input = '5*-4';

        $expected = [
            'Consecutive operators are not allowed',
        ];

        $result = $this->rule->validate($input);

        $this->assertSame($expected, $result);
    }

}
