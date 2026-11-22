<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name:'order_item',indexes:[new ORM\Index(name:'idx_item_order',columns:['order_id']),new ORM\Index(name:'idx_item_product',columns:['product_id'])])]
class OrderItem
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column] private ?int $id=null;
    #[ORM\ManyToOne(targetEntity:SalesOrder::class,inversedBy:'items')]
    #[ORM\JoinColumn(name:'order_id',nullable:false,onDelete:'RESTRICT')]
    private SalesOrder $order;
    #[ORM\ManyToOne(targetEntity:Product::class,inversedBy:'orderItems')]
    #[ORM\JoinColumn(name:'product_id',nullable:false,onDelete:'RESTRICT')]
    private Product $product;
    #[ORM\Column(type:'integer')] #[Assert\Positive] private int $quantity;
    #[ORM\Column(name:'unit_price_cents',type:'integer')] #[Assert\PositiveOrZero] private int $unitPriceCents;
    public function __construct(SalesOrder $order,Product $product,int $quantity,int $unitPriceCents) {
        if($quantity<1||$unitPriceCents<0)throw new \InvalidArgumentException('Invalid order item');
        $this->order=$order;$this->product=$product;$this->quantity=$quantity;$this->unitPriceCents=$unitPriceCents;
    }
    public function getId(): ?int{return $this->id;}
    public function getOrder(): SalesOrder{return $this->order;}
    public function getProduct(): Product{return $this->product;}
    public function getQuantity(): int{return $this->quantity;}
    public function getUnitPriceCents(): int{return $this->unitPriceCents;}
    public function getLineTotalCents(): int{return $this->quantity*$this->unitPriceCents;}
}
