<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

final readonly class Money
{
    public function __construct(public int $cents)
    {
        if ($cents < 0) {
            throw new InvalidArgumentException('Денежная сумма не может быть отрицательной.');
        }
    }

    public function format(string $currency = '₽'): string
    {
        return number_format(intdiv($this->cents, 100), 0, ',', ' ')
            . ',' . str_pad((string) ($this->cents % 100), 2, '0', STR_PAD_LEFT)
            . ' ' . $currency;
    }
}
