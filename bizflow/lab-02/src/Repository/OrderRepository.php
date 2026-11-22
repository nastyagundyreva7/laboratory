<?php
declare(strict_types=1);
namespace App\Repository;

use PDO;

/** PDO-based repository. All user-supplied values are bound parameters. */
final class OrderRepository
{
    public function __construct(private readonly PDO $pdo) {}

    public function create(int $customerId, string $description, int $amountCents): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO orders (customer_id, description, amount_cents, status) VALUES (:customer_id, :description, :amount_cents, :status)'
        );
        $stmt->execute(['customer_id' => $customerId, 'description' => $description,
            'amount_cents' => $amountCents, 'status' => 'new']);
        return (int) $this->pdo->lastInsertId();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT o.id, o.description, o.amount_cents, o.status, o.created_at, c.name AS customer_name
             FROM orders o JOIN customers c ON c.id = o.customer_id WHERE o.id = :id'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    public function search(string $term, int $limit = 20): array
    {
        $limit = max(1, min(100, $limit));
        $stmt = $this->pdo->prepare(
            'SELECT id, description, amount_cents, status, created_at FROM orders
             WHERE description LIKE :term ORDER BY created_at DESC LIMIT ' . $limit
        );
        $stmt->execute(['term' => '%' . $term . '%']);
        return $stmt->fetchAll();
    }

    /** Demonstrates an atomic multi-step operation. */
    public function createWithAudit(int $customerId, string $description, int $amountCents): int
    {
        $this->pdo->beginTransaction();
        try {
            $id = $this->create($customerId, $description, $amountCents);
            $audit = $this->pdo->prepare(
                'INSERT INTO audit_log (entity_type, entity_id, action) VALUES (:type, :id, :action)'
            );
            $audit->execute(['type' => 'order', 'id' => $id, 'action' => 'created']);
            $this->pdo->commit();
            return $id;
        } catch (\Throwable $e) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            throw $e;
        }
    }
}
