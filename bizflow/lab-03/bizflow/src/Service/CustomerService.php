<?php
declare(strict_types=1);
namespace App\Service;

final class CustomerService
{
    /** @return list<array{id:int,name:string,email:string,company:string}> */
    public function all(): array { return array_values($this->records()); }

    public function find(int $id): ?array { return $this->records()[$id] ?? null; }

    private function records(): array
    {
        return [
            1 => ['id' => 1, 'name' => 'Иван Иванов', 'email' => 'ivan@example.com', 'company' => 'ООО Ромашка'],
            2 => ['id' => 2, 'name' => 'Анна Смирнова', 'email' => 'anna@example.com', 'company' => 'Вектор'],
        ];
    }
}
