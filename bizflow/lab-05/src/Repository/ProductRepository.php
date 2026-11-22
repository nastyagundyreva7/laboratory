<?php
namespace App\Repository;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry){parent::__construct($registry,Product::class);}
    public function findTopSellingProducts(int $limit=5): array {
        return $this->createQueryBuilder('p')->select('p.id AS productId','p.name AS productName','p.sku AS sku','SUM(i.quantity) AS unitsSold','SUM(i.quantity * i.unitPriceCents) AS revenueCents')
            ->innerJoin('p.orderItems','i')->innerJoin('i.order','o')->andWhere('o.status IN (:statuses)')
            ->setParameter('statuses',['paid','shipped'])->groupBy('p.id')->orderBy('unitsSold','DESC')->setMaxResults($limit)->getQuery()->getArrayResult();
    }
}
