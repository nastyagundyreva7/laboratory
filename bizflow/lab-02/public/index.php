<?php
declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Database\ConnectionFactory;
use App\Http\Response;
use App\Repository\CustomerMysqliRepository;
use App\Repository\OrderRepository;
use App\Repository\ReportRepository;
use App\Service\OrderService;

try {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    if ($path === '/' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        Response::json(['app' => 'BizFlow', 'lab' => 2, 'routes' => ['/health', '/customers/find?email=', '/orders?id=', '/orders/search?q=', '/orders (POST)', '/reports/status', '/reports/customers']]);
    }
    if ($path === '/health') Response::json(['status' => 'ok', 'database' => 'not_checked']);

    $pdo = ConnectionFactory::pdo();
    $orders = new OrderRepository($pdo);
    if ($path === '/orders' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $id = (new OrderService($orders))->place((int)($input['customer_id'] ?? 0), (string)($input['description'] ?? ''), (int)($input['amount_cents'] ?? 0));
        Response::json(['created' => true, 'id' => $id], 201);
    }
    if ($path === '/orders' && isset($_GET['id'])) {
        $row = $orders->findById((int)$_GET['id']);
        Response::json(['order' => $row], $row ? 200 : 404);
    }
    if ($path === '/orders/search') Response::json(['items' => $orders->search((string)($_GET['q'] ?? ''))]);
    if ($path === '/customers/find') {
        $customer = (new CustomerMysqliRepository(ConnectionFactory::mysqli()))->findByEmail((string)($_GET['email'] ?? ''));
        Response::json(['customer' => $customer], $customer ? 200 : 404);
    }
    $reports = new ReportRepository($pdo);
    if ($path === '/reports/status') Response::json(['items' => $reports->totalsByStatus()]);
    if ($path === '/reports/customers') Response::json(['items' => $reports->topCustomers((int)($_GET['limit'] ?? 10))]);
    Response::json(['error' => 'Not found'], 404);
} catch (InvalidArgumentException $e) {
    Response::json(['error' => $e->getMessage()], 400);
} catch (Throwable $e) {
    error_log((string)$e);
    Response::json(['error' => 'Internal server error'], 500);
}
