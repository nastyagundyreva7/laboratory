<?php
namespace App\Tests\Unit;
use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\SalesOrder;
use PHPUnit\Framework\TestCase;
final class EntityRulesTest extends TestCase
{
    public function testEmailIsNormalizedToLowercase(): void { self::assertSame('user@example.test',(new Customer('A','USER@EXAMPLE.TEST'))->getEmail()); }
    public function testOrderRejectsUnknownStatus(): void {
        $this->expectException(\InvalidArgumentException::class);new SalesOrder(new Customer('A','a@example.test'),'unknown');
    }
    public function testProductRejectsNegativeMoney(): void {
        $this->expectException(\InvalidArgumentException::class);new Product('P','P-1',-1,100);
    }
}
