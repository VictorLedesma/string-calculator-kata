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
        $numbers = "";
        $expected = "0";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_returns_the_same_number_for_a_single_number(): void
    {
        $numbers = "1";
        $expected = "1";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_returns_the_sum_of_two_numbers(): void
    {
        $numbers = "1,2";
        $expected = "3";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_returns_the_sum_of_an_arbitrary_amount_of_numbers(): void
    {
        $numbers = "1,2,3,4,5,6,7";
        $expected = "28";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_returns_the_sum_for_numbers_separated_by_line_breaks(): void
    {
        $numbers = "1\n2,3";
        $expected = "6";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_returns_error_when_line_break_follows_a_comma(): void
    {
        $numbers = "1,\n";
        $expected = "Error: Invalid input";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_can_not_finish_with_a_separator(): void
    {
        $numbers = "1,2,";
        $expected = "Error: Invalid input";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_allows_custom_separators(): void
    {
        $numbers = "//;\n1;2";
        $expected = "3";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_allows_pipe_as_a_custom_separator(): void
    {
        $numbers = "//|\n1|2|3";
        $expected = "6";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_allows_multi_character_custom_separators(): void
    {
        $numbers = "//sep\nsep2sep3";
        $expected = "5";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_cant_work_with_negative_numbers(): void
    {
        $numbers = "-1,2";
        $expected = "Negative not allowed: -1";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_cant_work_with_multiple_negative_numbers(): void
    {
        $numbers = "2,-4,-5";
        $expected = "Negative not allowed: -4, -5";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_returns_multiple_errors(): void
    {
        $numbers = "-1,,2";
        $expected = "Negative not allowed: -1\nNumber expected but ',' found at position 3";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_returns_multiple_errors_in_order(): void
    {
        $numbers = "-1,,-2";
        $expected = "Negative not allowed: -1\nNumber expected but ',' found at position 3\nNegative not allowed: -2";

        $result = $this->calculator->add($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_multiplies_two_numbers(): void
    {
        $numbers = "2,3";
        $expected = "6";

        $result = $this->calculator->multiply($numbers);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_multiplies_an_arbitrary_amount_of_numbers(): void
    {
        $numbers = "2,3,4";
        $expected = "24";

        $result = $this->calculator->multiply($numbers);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_return_zero_for_an_empty_string_when_multiplying(): void
    {
        $numbers = '';
        $expected = '0';

        $result = $this->calculator->multiply($numbers);

        $this->assertSame($expected, $result);
    }

    #[Test]
    public function it_returns_the_product_for_numbers_separated_by_line_breaks(): void
    {
        $numbers = "1\n2,3";
        $expected = "6";

        $result = $this->calculator->multiply($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_returns_error_when_line_break_follows_a_comma_multiply_case(): void
    {
        $numbers = "1,\n";
        $expected = "Error: Invalid input";

        $result = $this->calculator->multiply($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_can_not_finish_with_a_separator_multiply_case(): void
    {
        $numbers = "1,2,";
        $expected = "Error: Invalid input";

        $result = $this->calculator->multiply($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_allows_custom_separators_multiply_case(): void
    {
        $numbers = "//;\n2;2";
        $expected = "4";

        $result = $this->calculator->multiply($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_allows_multi_character_custom_separators_multiply_case(): void
    {
        $numbers = "//sep\n1sep2sep3";
        $expected = "6";

        $result = $this->calculator->multiply($numbers);

        $this->assertSame($expected, $result);

    }

    #[Test]
    public function it_cant_work_with_multiple_negative_numbers_mutiply_case(): void
    {
        $numbers = "2,-4,-5";
        $expected = "Negative not allowed: -4, -5";

        $result = $this->calculator->multiply($numbers);

        $this->assertSame($expected, $result);

    }

}
