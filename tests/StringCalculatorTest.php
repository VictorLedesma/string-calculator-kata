<?php

declare(strict_types=1);

namespace MRC\StringCalculator\Test;

use MRC\StringCalculator\StringCalculator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class StringCalculatorTest extends TestCase
{
    private StringCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new StringCalculator();
    }

    #[Test]
    public function it_returns_zero_for_an_empty_string(): void
    {
        $this->assertSame('0', $this->calculator->add(''));
    }

    #[Test]
    public function it_returns_the_same_number_for_a_single_number(): void
    {
        $this->assertSame('1', $this->calculator->add('1'));
    }

    #[Test]
    public function it_returns_the_sum_of_two_numbers(): void
    {
        $this->assertSame('3', $this->calculator->add('1,2'));
    }

    #[Test]
    public function it_returns_the_sum_of_an_arbitrary_amount_of_numbers(): void
    {
        $this->assertSame('28', $this->calculator->add('1,2,3,4,5,6,7'));
    }
}
