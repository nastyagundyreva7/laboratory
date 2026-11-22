<?php
declare(strict_types=1);
namespace App\Database;

use PDO;
use mysqli;

final class ConnectionFactory
{
    private static function config(string $key, string $default): string
    {
        $value = getenv($key);
        return $value === false ? $default : $value;
    }

    public static function pdo(): PDO
    {
        $host = self::config('DB_HOST', '127.0.0.1');
        $port = self::config('DB_PORT', '3306');
        $db = self::config('DB_NAME', 'bizflow');
        $charset = self::config('DB_CHARSET', 'utf8mb4');
        $pdo = new PDO(
            "mysql:host={$host};port={$port};dbname={$db};charset={$charset}",
            self::config('DB_USER', 'root'),
            self::config('DB_PASSWORD', ''),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
             PDO::ATTR_EMULATE_PREPARES => false]
        );
        return $pdo;
    }

    public static function mysqli(): mysqli
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $db = new mysqli(
            self::config('DB_HOST', '127.0.0.1'),
            self::config('DB_USER', 'root'),
            self::config('DB_PASSWORD', ''),
            self::config('DB_NAME', 'bizflow'),
            (int) self::config('DB_PORT', '3306')
        );
        $db->set_charset(self::config('DB_CHARSET', 'utf8mb4'));
        return $db;
    }
}
