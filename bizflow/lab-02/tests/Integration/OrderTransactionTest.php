<?php
declare(strict_types=1);
namespace App\Tests\Integration;

use App\Database\ConnectionFactory;
use App\Repository\OrderRepository;
use PHPUnit\Framework\TestCase;

final class OrderTransactionTest extends TestCase
{
    public function testOrderAndAuditRecordAreCreatedTogether(): void
    {
        $pdo = ConnectionFactory::pdo();
        $pdo->exec("INSERT IGNORE INTO customers (name,email) VALUES ('Transaction Test','transaction@example.test')");
        $customerId = (int)$pdo->query("SELECT id FROM customers WHERE email='transaction@example.test'")->fetchColumn();
        $repo = new OrderRepository($pdo);
        $id = $repo->createWithAudit($customerId, 'Transactional item', 12345);
        self::assertNotNull($repo->findById($id));
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM audit_log WHERE entity_type = ? AND entity_id = ? AND action = ?");
        $stmt->execute(['order', $id, 'created']);
        self::assertSame(1, (int)$stmt->fetchColumn());
    }
}
