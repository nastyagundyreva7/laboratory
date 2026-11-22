<?php
declare(strict_types=1);
namespace App\Controller;

use App\Service\CustomerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CustomerController extends AbstractController
{
    public function __construct(private readonly CustomerService $customers) {}

    #[Route('/customers', name: 'customer_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('customer/index.html.twig', ['customers' => $this->customers->all()]);
    }

    #[Route('/customers/{id}', name: 'customer_show', requirements: ['id' => '[1-9]\d*'], methods: ['GET'])]
    public function show(int $id): Response
    {
        $customer = $this->customers->find($id);
        if ($customer === null) {
            throw $this->createNotFoundException('Клиент не найден.');
        }
        return $this->render('customer/show.html.twig', ['customer' => $customer]);
    }
}
