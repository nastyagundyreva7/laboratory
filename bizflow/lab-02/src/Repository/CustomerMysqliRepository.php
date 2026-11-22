<?php
declare(strict_types=1);
namespace App\Repository;

use mysqli;

/** mysqli-based repository, included to compare both PHP MySQL APIs. */
final class CustomerMysqliRepository
{
    public function __construct(private readonly mysqli $db) {}

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT id, name, email, created_at FROM customers WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc() ?: null;
        $stmt->close();
        return $row;
    }

    public function create(string $name, string $email): int
    {
        $stmt = $this->db->prepare('INSERT INTO customers (name, email) VALUES (?, ?)');
        $stmt->bind_param('ss', $name, $email);
        $stmt->execute();
        $id = $this->db->insert_id;
        $stmt->close();
        return $id;
    }
}
