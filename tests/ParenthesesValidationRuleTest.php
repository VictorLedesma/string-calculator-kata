<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\Validation\ConsecutiveOperatorsRule;
use MRC\StringCalculator\Rules\Validation\ParenthesesValidationRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ParenthesesValidationRuleTest extends TestCase
{
    private ParenthesesValidationRule $rule;

    protected function setUp(): void
    {
        $this->rule = new ParenthesesValidationRule();
    }

    #[Test]
    public function it_detects_empty_parentheses(): void
    {
        // Arrange
        $input = '()';

        $expected = [
            'Invalid parentheses',
        ];

        // Act
        $result = $this->rule->validate($input);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_detect_uncompleted_parentheses(): void
    {
        // Arrange
        $input = '(2*3)+4)';

        $expected = [
            'Invalid parentheses',
        ];

        // Act
        $result = $this->rule->validate($input);

        $this->assertSame($expected, $result);
    }

}
