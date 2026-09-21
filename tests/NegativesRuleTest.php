<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\Rules\NegativesRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class NegativesRuleTest extends TestCase
{
    private NegativesRule $rule;

    protected function setUp(): void
    {
        $this->rule = new NegativesRule();
    }

    #[Test]
    public function it_cant_allows_negative_number(): void
    {
        $input = '-1,2';
        $expected = ['Negatives not allowed: -1',];

        $result = $this->rule->validate($input);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_cant_allows_an_arbitrary_amount_of_negatives(): void
    {
        $input = '-1,-2';
        $expected = [
            'Negatives not allowed: -1,-2'
        ];

        $result = $this->rule->validate($input);

        $this->assertSame($expected, $result);
    }

}

