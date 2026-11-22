<?php
namespace App\Service;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use App\Repository\SalesOrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class DashboardProvider
{
    public function __construct(private EntityManagerInterface $em, private CustomerRepository $customers,
        private ProductRepository $products, private SalesOrderRepository $orders) {}
    public function getData(): array {
        $customerCount=(int)$this->em->createQuery('SELECT COUNT(c.id) FROM App\\Entity\\Customer c')->getSingleScalarResult();
        $orderCount=(int)$this->em->createQuery('SELECT COUNT(o.id) FROM App\\Entity\\SalesOrder o')->getSingleScalarResult();
        return [
            'customerCount'=>$customerCount, 'orderCount'=>$orderCount,
            'revenueCents'=>$this->orders->revenueCents(),
            'averageOrderCents'=>$this->orders->averageOrderCents(),
            'topCustomers'=>$this->customers->findTopByRevenue(),
            'topProducts'=>$this->products->findTopSellingProducts()
        ];
    }
}
