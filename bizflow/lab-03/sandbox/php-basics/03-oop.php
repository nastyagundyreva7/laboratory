<?php
declare(strict_types=1);

final class Customer
{
    private static int $createdCount = 0;

    public function __construct(
        private int $id,
        private string $name,
        private string $email,
    ) { self::$createdCount++; }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public static function getCreatedCount(): int { return self::$createdCount; }
}

interface CustomerFormatterInterface
{
    public function format(Customer $customer): string;
}

final class CustomerFormatter implements CustomerFormatterInterface
{
    public function format(Customer $customer): string
    {
        return sprintf('%d: %s <%s>', $customer->getId(), $customer->getName(), $customer->getEmail());
    }
}

$customer = new Customer(1, 'Иван Иванов', 'ivan@example.com');
$formatter = new CustomerFormatter();
echo $formatter->format($customer) . PHP_EOL;
echo 'Создано объектов: ' . Customer::getCreatedCount() . PHP_EOL;
