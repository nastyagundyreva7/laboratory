<?php

declare(strict_types=1);

namespace App\Tests;

use App\Service\QuoteCalculator;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class QuoteCalculatorTest extends TestCase
{
    private QuoteCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new QuoteCalculator();
    }

    public function testNormalCalculation(): void
    {
        $quote = $this->calculator->calculate(10, 1250, 7);
        self::assertSame(12500, $quote->subtotal->cents);
        self::assertSame(875, $quote->discountAmount->cents);
        self::assertSame(11625, $quote->total->cents);
    }

    public function testZeroDiscount(): void
    {
        self::assertSame(12500, $this->calculator->calculate(10, 1250, 0)->total->cents);
    }

    public function testMaximumDiscount(): void
    {
        self::assertSame(6250, $this->calculator->calculate(10, 1250, 50)->total->cents);
    }

    #[DataProvider('invalidValues')]
    public function testInvalidValuesAreRejected(int $qty, int $price, int $discount): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->calculate($qty, $price, $discount);
    }

    public static function invalidValues(): iterable
    {
        yield 'zero quantity' => [0, 1250, 7];
        yield 'negative quantity' => [-1, 1250, 7];
        yield 'negative price' => [1, -10, 7];
        yield 'zero price' => [1, 0, 7];
        yield 'discount above maximum' => [1, 100, 51];
        yield 'negative discount' => [1, 100, -1];
    }

    public function testDiscountRoundsHalfUpToWholeKopeck(): void
    {
        // 1 копейка * 50% = 0,5 копейки; ожидаем 1 копейку скидки.
        $quote = $this->calculator->calculate(1, 1, 50);
        self::assertSame(1, $quote->discountAmount->cents);
        self::assertSame(0, $quote->total->cents);
    }
}
