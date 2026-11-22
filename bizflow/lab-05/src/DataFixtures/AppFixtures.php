<?php
namespace App\DataFixtures;
use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\SalesOrder;
use App\Entity\OrderItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $customers=[];
        for($i=1;$i<=24;$i++){
            $c=new Customer(sprintf('Клиент %02d',$i),sprintf('client%02d@example.test',$i));
            $c->setCompany(sprintf('Компания %02d',$i))->setPhone(sprintf('+7-900-%03d-%02d-%02d',100+$i,$i,$i));
            $manager->persist($c);$customers[]=$c;
        }
        $products=[];
        for($i=1;$i<=36;$i++){
            $p=new Product(sprintf('Товар %02d',$i),sprintf('SKU-%04d',$i),500+$i*37,900+$i*61);
            $p->setActive($i%9!==0);$manager->persist($p);$products[]=$p;
        }
        $manager->flush();
        for($i=1;$i<=60;$i++){
            $status=['pending','paid','shipped','cancelled','draft'][($i-1)%5];
            $order=new SalesOrder($customers[($i*7)%24],$status);$manager->persist($order);
            $lineCount=2+($i%3);
            for($j=0;$j<$lineCount;$j++){
                $product=$products[($i*3+$j*5)%36];
                // Историческая цена фиксируется в OrderItem при создании позиции.
                $item=new OrderItem($order,$product,1+(($i+$j)%4),$product->getPriceCents());
                $manager->persist($item);
            }
        }
        $manager->flush();
    }
}
