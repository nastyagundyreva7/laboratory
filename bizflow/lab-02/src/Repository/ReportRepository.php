<?php
declare(strict_types=1);
namespace App\Repository;

use PDO;

final class ReportRepository
{
    public function __construct(private readonly PDO $pdo) {}

    /** Aggregate report: order count and revenue grouped by status. */
    public function totalsByStatus(): array
    {
        return $this->pdo->query(
            'SELECT status, COUNT(*) AS orders_count, COALESCE(SUM(amount_cents), 0) AS revenue_cents
             FROM orders GROUP BY status ORDER BY status'
        )->fetchAll();
    }

    /** JOIN + GROUP BY report: top customers by total order value. */
    public function topCustomers(int $limit = 10): array
    {
        $limit = max(1, min(50, $limit));
        $stmt = $this->pdo->query(
            'SELECT c.id, c.name, c.email, COUNT(o.id) AS orders_count,
                    COALESCE(SUM(o.amount_cents), 0) AS total_cents
             FROM customers c LEFT JOIN orders o ON o.customer_id = c.id
             GROUP BY c.id, c.name, c.email ORDER BY total_cents DESC LIMIT ' . $limit
        );
        return $stmt->fetchAll();
    }
}
