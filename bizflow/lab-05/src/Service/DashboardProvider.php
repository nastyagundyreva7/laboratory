<?php
declare(strict_types=1);
namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
class DashboardProvider {
 public function __construct(private EntityManagerInterface $em){}
 public function getData():array {
  $students=(int)$this->em->createQuery('SELECT COUNT(s.id) FROM App\Entity\Student s')->getSingleScalarResult();
  $wallets=(int)$this->em->createQuery('SELECT COUNT(w.id) FROM App\Entity\Wallet w')->getSingleScalarResult();
  $coins=(int)$this->em->createQuery('SELECT COALESCE(SUM(w.balance),0) FROM App\Entity\Wallet w')->getSingleScalarResult();
  $transactions=$this->em->createQuery('SELECT t, w, s FROM App\Entity\CoinTransaction t JOIN t.wallet w JOIN w.student s ORDER BY t.createdAt DESC')->setMaxResults(8)->getResult();
  $events=$this->em->getRepository(\App\Entity\UniversityEvent::class)->findBy([],['startsAt'=>'ASC'],5);
  $privileges=$this->em->getRepository(\App\Entity\Privilege::class)->findBy(['active'=>true],['costCoins'=>'ASC'],5);
  return compact('students','wallets','coins','transactions','events','privileges');
 }
}
