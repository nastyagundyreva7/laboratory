<?php

declare(strict_types=1);

namespace App\Domain;

final readonly class Quote
{
    public function __construct(
        public int $quantity,
        public Money $unitPrice,
        public int $discountPercent,
        public Money $subtotal,
        public Money $discountAmount,
        public Money $total,
    ) {}
}
