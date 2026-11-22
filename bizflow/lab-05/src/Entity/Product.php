<?php
namespace App\Entity;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'product', indexes: [new ORM\Index(name: 'idx_product_active', columns: ['active'])])]
#[ORM\UniqueConstraint(name: 'uniq_product_sku', columns: ['sku'])]
class Product
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column] private ?int $id=null;
    #[ORM\Column(length: 180)] #[Assert\NotBlank] private string $name;
    #[ORM\Column(length: 64)] #[Assert\NotBlank] private string $sku;
    #[ORM\Column(name:'cost_cents', type:'integer')] private int $costCents;
    #[ORM\Column(name:'price_cents', type:'integer')] private int $priceCents;
    #[ORM\Column(type:'boolean', options:['default'=>true])] private bool $active=true;
    #[ORM\Column(name:'created_at', type:'datetime_immutable')] private \DateTimeImmutable $createdAt;
    /** @var Collection<int, OrderItem> */
    #[ORM\OneToMany(mappedBy:'product', targetEntity:OrderItem::class)] private Collection $orderItems;
    public function __construct(string $name,string $sku,int $costCents,int $priceCents) {
        if ($costCents < 0 || $priceCents < 0) throw new \InvalidArgumentException('Money cannot be negative');
        $this->name=$name; $this->sku=$sku; $this->costCents=$costCents; $this->priceCents=$priceCents;
        $this->createdAt=new \DateTimeImmutable(); $this->orderItems=new ArrayCollection();
    }
    public function getId(): ?int{return $this->id;}
    public function getName(): string{return $this->name;}
    public function getSku(): string{return $this->sku;}
    public function getCostCents(): int{return $this->costCents;}
    public function getPriceCents(): int{return $this->priceCents;}
    public function isActive(): bool{return $this->active;}
    public function setActive(bool $v): self{$this->active=$v;return $this;}
    public function getCreatedAt(): \DateTimeImmutable{return $this->createdAt;}
    public function getOrderItems(): Collection{return $this->orderItems;}
}
