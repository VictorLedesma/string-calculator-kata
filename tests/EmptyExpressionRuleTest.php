<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\Validation\EmptyExpressionRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class EmptyExpressionRuleTest extends TestCase
{
    private EmptyExpressionRule $rule;

    protected function setUp(): void
    {
        $this->rule = new EmptyExpressionRule();
    }

    #[Test]
    public function it_detects_empty_expression(): void
    {
        // Arrange
        $input = '';

        $expected = [
            'Expression cannot be empty',
        ];

        // Act
        $result = $this->rule->validate($input);

        // Assert
        $this->assertSame($expected, $result);
    }

}
