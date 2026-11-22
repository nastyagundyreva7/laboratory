<?php
declare(strict_types=1);
namespace App\DataFixtures;
use App\Entity\Student;use App\Entity\Wallet;use App\Entity\UniversityEvent;use App\Entity\Privilege;
use Doctrine\Bundle\FixturesBundle\Fixture;use Doctrine\Persistence\ObjectManager;
final class AppFixtures extends Fixture { public function load(ObjectManager $manager):void {
  $student=new Student('Анастасия Гундырева','student@example.com','Высшая школа управления','Бизнес-информатика');$wallet=new Wallet($student);$wallet->apply(150,'earn','Демонстрационное начисление за участие');$wallet->apply(50,'earn','Демонстрационное начисление за активность');$manager->persist($student);$manager->persist($wallet);
  $manager->persist(new UniversityEvent('Вводная встреча RUD COIN','Демонстрационное мероприятие программы',new \DateTimeImmutable('+7 days'),100));
  $manager->persist(new UniversityEvent('Научный семинар','Демонстрационное мероприятие программы',new \DateTimeImmutable('+14 days'),150));
  $manager->persist(new Privilege('Консультация наставника','Демонстрационная привилегия',100));$manager->persist(new Privilege('Мерч университета','Демонстрационная привилегия',250));$manager->flush();
 } }
