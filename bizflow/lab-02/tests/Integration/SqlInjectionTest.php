<?php
declare(strict_types=1);
namespace App\Tests\Integration;

use App\Database\ConnectionFactory;
use App\Repository\CustomerMysqliRepository;
use PHPUnit\Framework\TestCase;

/** Requires a disposable MySQL database configured in phpunit.xml / environment. */
final class SqlInjectionTest extends TestCase
{
    public function testMaliciousEmailIsTreatedAsData(): void
    {
        $pdo = ConnectionFactory::pdo();
        $pdo->exec('CREATE TABLE IF NOT EXISTS customers (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(120) NOT NULL, email VARCHAR(190) NOT NULL UNIQUE, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB');
        $pdo->exec("INSERT IGNORE INTO customers (name,email) VALUES ('Test User','safe@example.test')");
        $repository = new CustomerMysqliRepository(ConnectionFactory::mysqli());
        $payload = "' OR '1'='1";
        self::assertNull($repository->findByEmail($payload), 'Injection payload must not return an arbitrary customer.');
        self::assertNotNull($repository->findByEmail('safe@example.test'));
    }
}
