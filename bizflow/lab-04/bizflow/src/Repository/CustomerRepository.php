<?php
declare(strict_types=1);
namespace App\Repository;
use App\Model\Customer;
use Symfony\Component\HttpFoundation\RequestStack;
final class CustomerRepository
{
    private const STORAGE_KEY = 'bizflow_customers';
    public function __construct(private RequestStack $requestStack) {}
    /** @return array<int, Customer> */
    private function records(): array {
        $session = $this->requestStack->getSession();
        $records = $session->get(self::STORAGE_KEY);
        if (!is_array($records)) {
            $records = [
                1 => new Customer('Анна Смирнова','anna@example.test','+7 900 111-22-33','Northwind','Постоянный клиент',1),
                2 => new Customer('Иван Петров','ivan@example.test','+7 900 222-33-44','Contoso','Новый запрос',2),
            ];
            $session->set(self::STORAGE_KEY, $records);
        }
        return $records;
    }
    public function save(Customer $customer): Customer {
        $records = $this->records();
        if ($customer->id === null) { $customer->id = $records === [] ? 1 : max(array_keys($records)) + 1; }
        $records[$customer->id] = $customer;
        $this->requestStack->getSession()->set(self::STORAGE_KEY, $records);
        return $customer;
    }
    public function find(int $id): ?Customer { $records = $this->records(); return $records[$id] ?? null; }
    /** @return list<Customer> */
    public function all(string $search = '', string $sort = 'name'): array {
        $items = array_values(array_filter($this->records(), static function (Customer $customer) use ($search): bool {
            return $search === '' || str_contains(mb_strtolower($customer->name), mb_strtolower($search)) || str_contains(mb_strtolower($customer->email), mb_strtolower($search)) || str_contains(mb_strtolower($customer->company), mb_strtolower($search));
        }));
        $field = in_array($sort, ['name', 'email'], true) ? $sort : 'name';
        usort($items, static fn (Customer $a, Customer $b): int => strcasecmp($a->{$field}, $b->{$field}));
        return $items;
    }
}
