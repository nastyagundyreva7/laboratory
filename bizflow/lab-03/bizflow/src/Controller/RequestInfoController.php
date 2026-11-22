<?php
declare(strict_types=1);
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class RequestInfoController
{
    #[Route('/request-info', name: 'request_info', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse([
            'method' => $request->getMethod(),
            'path' => $request->getPathInfo(),
            'query' => $request->query->all(),
            'userAgent' => $request->headers->get('User-Agent', ''),
        ]);
    }
}
