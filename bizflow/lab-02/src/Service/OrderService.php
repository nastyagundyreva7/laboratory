<?php
declare(strict_types=1);
namespace App\Service;

use App\Repository\OrderRepository;

final class OrderService
{
    public function __construct(private readonly OrderRepository $orders) {}

    public function place(int $customerId, string $description, int $amountCents): int
    {
        if ($customerId < 1) throw new \InvalidArgumentException('Некорректный клиент.');
        $description = trim($description);
        if ($description === '' || mb_strlen($description) > 255) {
            throw new \InvalidArgumentException('Описание должно содержать от 1 до 255 символов.');
        }
        if ($amountCents < 1) throw new \InvalidArgumentException('Сумма должна быть положительной (в копейках).');
        return $this->orders->createWithAudit($customerId, $description, $amountCents);
    }
}
