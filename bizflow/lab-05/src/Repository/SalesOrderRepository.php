<?php
namespace App\Repository;
use App\Entity\SalesOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
class SalesOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry){parent::__construct($registry,SalesOrder::class);}
    public function findByPeriod(\DateTimeImmutable $from,\DateTimeImmutable $to): array {
        return $this->createQueryBuilder('o')->addSelect('c')->join('o.customer','c')
            ->andWhere('o.createdAt >= :from')->andWhere('o.createdAt < :to')
            ->setParameter('from',$from)->setParameter('to',$to)->orderBy('o.createdAt','DESC')->getQuery()->getResult();
    }
    public function findByCustomer(int $customerId,int $page=1,int $perPage=10): array {
        return $this->createQueryBuilder('o')->addSelect('c')->join('o.customer','c')->andWhere('c.id=:id')
            ->setParameter('id',$customerId)->orderBy('o.createdAt','DESC')->setFirstResult(($page-1)*$perPage)->setMaxResults($perPage)->getQuery()->getResult();
    }
    public function countByCustomer(int $customerId): int {
        return (int)$this->createQueryBuilder('o')->select('COUNT(o.id)')->andWhere('o.customer=:id')->setParameter('id',$customerId)->getQuery()->getSingleScalarResult();
    }
    public function findByStatus(string $status): array {
        return $this->createQueryBuilder('o')->andWhere('o.status=:status')->setParameter('status',$status)->orderBy('o.createdAt','DESC')->getQuery()->getResult();
    }
    public function revenueCents(): int {
        // DQL aggregate: суммы строк заказов в оплаченных/отгруженных заказах.
        return (int)$this->getEntityManager()->createQuery(
            'SELECT COALESCE(SUM(i.quantity * i.unitPriceCents), 0) FROM App\\Entity\\OrderItem i JOIN i.order o WHERE o.status IN (:statuses)'
        )->setParameter('statuses',['paid','shipped'])->getSingleScalarResult();
    }
    public function averageOrderCents(): float {
        // DQL не поддерживает derived table во FROM; среднее считается через QueryBuilder агрегат по заказам.
        $rows=$this->createQueryBuilder('o')->select('SUM(i.quantity * i.unitPriceCents) AS totalCents')
            ->join('o.items','i')->andWhere('o.status IN (:statuses)')->setParameter('statuses',['paid','shipped'])
            ->groupBy('o.id')->getQuery()->getScalarResult();
        if (!$rows) return 0.0;
        return array_sum(array_map(static fn($r)=>(float)$r['totalCents'],$rows))/count($rows);
    }
}
