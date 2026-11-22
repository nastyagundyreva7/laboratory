<?php
declare(strict_types=1);
namespace App\Controller;

use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrderController extends AbstractController
{
    public function __construct(private readonly OrderService $orders) {}

    #[Route('/orders', name: 'order_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('order/index.html.twig', ['orders' => $this->orders->all()]);
    }

    #[Route('/orders/{id}', name: 'order_show', requirements: ['id' => '[1-9]\d*'], methods: ['GET'])]
    public function show(int $id): Response
    {
        $order = $this->orders->find($id);
        if ($order === null) {
            throw $this->createNotFoundException('Заказ не найден.');
        }
        return $this->render('order/show.html.twig', ['order' => $order]);
    }
}
