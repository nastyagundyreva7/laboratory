<?php
namespace App\Entity;
use App\Repository\SalesOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalesOrderRepository::class)]
#[ORM\Table(name:'sales_order', indexes:[new ORM\Index(name:'idx_order_status_created',columns:['status','created_at']),new ORM\Index(name:'idx_order_customer_created',columns:['customer_id','created_at'])])]
class SalesOrder
{
    public const STATUSES=['draft','pending','paid','shipped','cancelled'];
    #[ORM\Id, ORM\GeneratedValue, ORM\Column] private ?int $id=null;
    #[ORM\ManyToOne(targetEntity:Customer::class,inversedBy:'orders')]
    #[ORM\JoinColumn(name:'customer_id',nullable:false,onDelete:'RESTRICT')]
    private Customer $customer;
    #[ORM\Column(length:24)] private string $status='pending';
    #[ORM\Column(name:'created_at',type:'datetime_immutable')] private \DateTimeImmutable $createdAt;
    #[ORM\Column(name:'updated_at',type:'datetime_immutable')] private \DateTimeImmutable $updatedAt;
    /** @var Collection<int, OrderItem> */
    #[ORM\OneToMany(mappedBy:'order',targetEntity:OrderItem::class)] private Collection $items;
    public function __construct(Customer $customer,string $status='pending') {
        if (!in_array($status,self::STATUSES,true)) throw new \InvalidArgumentException('Unknown order status');
        $this->customer=$customer;$this->status=$status;$this->createdAt=new \DateTimeImmutable();
        $this->updatedAt=$this->createdAt;$this->items=new ArrayCollection();
    }
    public function getId(): ?int{return $this->id;}
    public function getCustomer(): Customer{return $this->customer;}
    public function getStatus(): string{return $this->status;}
    public function setStatus(string $v): self{if(!in_array($v,self::STATUSES,true))throw new \InvalidArgumentException();$this->status=$v;$this->updatedAt=new \DateTimeImmutable();return $this;}
    public function getCreatedAt(): \DateTimeImmutable{return $this->createdAt;}
    public function getUpdatedAt(): \DateTimeImmutable{return $this->updatedAt;}
    public function getItems(): Collection{return $this->items;}
}
