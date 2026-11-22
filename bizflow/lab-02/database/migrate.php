<?php
declare(strict_types=1);
require dirname(__DIR__) . '/vendor/autoload.php';
$pdo = App\Database\ConnectionFactory::pdo();
$sql = file_get_contents(__DIR__ . '/migrations/001_create_schema.sql');
foreach (array_filter(array_map('trim', explode(';', $sql))) as $statement) $pdo->exec($statement);
echo "Migration completed.\n";
