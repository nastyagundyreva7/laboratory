<?php
declare(strict_types=1);
namespace App\Service;

final class OrderService
{
    /** @return list<array{id:int,customer:string,total:string,status:string}> */
    public function all(): array { return array_values($this->records()); }
    public function find(int $id): ?array { return $this->records()[$id] ?? null; }
    private function records(): array
    {
        return [
            1 => ['id' => 1, 'customer' => 'Иван Иванов', 'total' => '12 500 ₽', 'status' => 'Оплачен'],
            2 => ['id' => 2, 'customer' => 'Анна Смирнова', 'total' => '8 900 ₽', 'status' => 'Новый'],
            3 => ['id' => 3, 'customer' => 'Иван Иванов', 'total' => '3 200 ₽', 'status' => 'В обработке'],
        ];
    }
}
