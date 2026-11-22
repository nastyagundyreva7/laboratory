<?php
namespace App\Repository;
use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry){parent::__construct($registry,Customer::class);}
    public function findActiveCustomers(): array {
        return $this->createQueryBuilder('c')->innerJoin('c.orders','o')->andWhere('o.status IN (:statuses)')
            ->setParameter('statuses',['pending','paid','shipped'])->distinct()->orderBy('c.name','ASC')->getQuery()->getResult();
    }
    public function findTopByRevenue(int $limit=5): array {
        return $this->createQueryBuilder('c')->select('c.id AS customerId','c.name AS customerName','c.company AS company','SUM(i.quantity * i.unitPriceCents) AS revenueCents')
            ->innerJoin('c.orders','o')->innerJoin('o.items','i')->andWhere('o.status IN (:statuses)')
            ->setParameter('statuses',['paid','shipped'])->groupBy('c.id')->orderBy('revenueCents','DESC')->setMaxResults($limit)->getQuery()->getArrayResult();
    }
}
