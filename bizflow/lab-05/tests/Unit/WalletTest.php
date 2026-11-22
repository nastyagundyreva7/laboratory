<?php
declare(strict_types=1);
namespace App\Tests\Unit;
use App\Entity\Student;use App\Entity\Wallet;use PHPUnit\Framework\TestCase;
final class WalletTest extends TestCase {
 public function testEarnAndSpendUpdateBalance():void{$student=new Student('Тестовый студент','test@example.com','ВШУ','Бизнес-информатика');$wallet=new Wallet($student);$wallet->apply(100,'earn','Начисление');$wallet->apply(35,'spend','Списание');self::assertSame(65,$wallet->getBalance());self::assertCount(2,$wallet->getTransactions());}
 public function testCannotSpendMoreThanBalance():void{$student=new Student('Тестовый студент','test@example.com','ВШУ','Бизнес-информатика');$wallet=new Wallet($student);$this->expectException(\DomainException::class);$wallet->apply(1,'spend','Списание');}
}
