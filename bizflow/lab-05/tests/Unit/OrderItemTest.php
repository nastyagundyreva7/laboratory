<?php
namespace App\Tests\Unit;
use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\SalesOrder;
use App\Entity\OrderItem;
use PHPUnit\Framework\TestCase;
final class OrderItemTest extends TestCase
{
    public function testLineTotalUsesIntegerMinorUnits(): void {
        $customer=new Customer('Test','test@example.test');$product=new Product('Widget','W-1',100,250);
        $order=new SalesOrder($customer,'paid');$item=new OrderItem($order,$product,3,240);
        self::assertSame(720,$item->getLineTotalCents());
    }
    public function testHistoricalPriceIsIndependentFromCurrentProductPrice(): void {
        $customer=new Customer('Test','test@example.test');$product=new Product('Widget','W-1',100,250);
        $item=new OrderItem(new SalesOrder($customer),$product,2,250);
        self::assertSame(250,$item->getUnitPriceCents());
        self::assertSame(500,$item->getLineTotalCents());
    }
    public function testRejectsZeroQuantity(): void {
        $this->expectException(\InvalidArgumentException::class);
        new OrderItem(new SalesOrder(new Customer('A','a@example.test')),new Product('P','P-1',1,2),0,2);
    }
}
