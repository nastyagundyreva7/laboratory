<?php
declare(strict_types=1);

$appName = 'BizFlow';
$maxCustomers = 100;
$isDebug = true;

echo $appName . PHP_EOL;
printf("Лимит клиентов: %d; режим отладки: %s\n", $maxCustomers, $isDebug ? 'включен' : 'выключен');

$customers = [
    ['id' => 1, 'name' => 'Иван Иванов', 'email' => 'ivan@example.com'],
    ['id' => 2, 'name' => 'Анна Смирнова', 'email' => 'anna@example.com'],
];

foreach ($customers as $customer) {
    echo $customer['id'] . ': ' . $customer['name'] . PHP_EOL;
}

function findCustomerById(array $customers, int $id): ?array
{
    foreach ($customers as $customer) {
        if ($customer['id'] === $id) {
            return $customer;
        }
    }
    return null;
}

$found = findCustomerById($customers, 2);
echo $found === null ? 'Клиент не найден' . PHP_EOL : $found['name'] . PHP_EOL;
