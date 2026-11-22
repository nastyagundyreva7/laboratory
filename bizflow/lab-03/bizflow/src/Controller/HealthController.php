<?php
declare(strict_types=1);
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class HealthController
{
    #[Route('/health', name: 'health', methods: ['GET'])]
    public function health(): JsonResponse
    {
        return new JsonResponse(['status' => 'ok', 'application' => 'BizFlow']);
    }

    public function version(): JsonResponse
    {
        return new JsonResponse(['application' => 'BizFlow', 'apiVersion' => '1.0']);
    }
}
