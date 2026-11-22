<?php

declare(strict_types=1);

namespace App\Service;

use App\Domain\Money;
use App\Domain\Quote;
use InvalidArgumentException;
use OverflowException;

final class QuoteCalculator
{
    public function calculate(int $quantity, int $priceCents, int $discountPercent): Quote
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('Количество должно быть больше нуля.');
        }
        if ($priceCents <= 0) {
            throw new InvalidArgumentException('Цена должна быть больше нуля копеек.');
        }
        if ($discountPercent < 0 || $discountPercent > 50) {
            throw new InvalidArgumentException('Скидка должна быть от 0 до 50 процентов.');
        }
        if ($quantity > intdiv(PHP_INT_MAX, $priceCents)) {
            throw new OverflowException('Сумма заказа слишком велика.');
        }

        $subtotal = $quantity * $priceCents;
        // Округление скидки до целой копейки по правилу half-up.
        $wholeHundreds = intdiv($subtotal, 100);
        $remainder = $subtotal % 100;
        $discountAmount = ($wholeHundreds * $discountPercent)
            + intdiv(($remainder * $discountPercent) + 50, 100);

        return new Quote(
            $quantity,
            new Money($priceCents),
            $discountPercent,
            new Money($subtotal),
            new Money($discountAmount),
            new Money($subtotal - $discountAmount),
        );
    }
}
