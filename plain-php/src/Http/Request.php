<?php

declare(strict_types=1);

namespace App\Http;

final readonly class Request
{
    /** @param array<string, mixed> $query */
    public function __construct(
        public string $method,
        public string $path,
        public array $query,
    ) {}

    public static function fromGlobals(): self
    {
        $uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        return new self(
            strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET'),
            is_string($uriPath) ? $uriPath : '/',
            $_GET,
        );
    }

    public function queryInt(string $key): ?int
    {
        $value = $this->query[$key] ?? null;
        if (!is_string($value) && !is_int($value)) {
            return null;
        }
        $validated = filter_var($value, FILTER_VALIDATE_INT);
        return $validated === false ? null : $validated;
    }
}
