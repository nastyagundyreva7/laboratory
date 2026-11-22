<?php
namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'customer', indexes: [new ORM\Index(name: 'idx_customer_created', columns: ['created_at'])])]
#[ORM\UniqueConstraint(name: 'uniq_customer_email', columns: ['email'])]
class Customer
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 160)]
    #[Assert\NotBlank, Assert\Length(max: 160)]
    private string $name;
    #[ORM\Column(length: 190)]
    #[Assert\NotBlank, Assert\Email, Assert\Length(max: 190)]
    private string $email;
    #[ORM\Column(length: 40, nullable: true)]
    private ?string $phone = null;
    #[ORM\Column(length: 160, nullable: true)]
    private ?string $company = null;
    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;
    /** @var Collection<int, SalesOrder> */
    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: SalesOrder::class)]
    private Collection $orders;

    public function __construct(string $name, string $email) {
        $this->name = $name; $this->email = mb_strtolower($email);
        $this->createdAt = new \DateTimeImmutable(); $this->orders = new ArrayCollection();
    }
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function setName(string $v): self { $this->name=$v; return $this; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $v): self { $this->email=mb_strtolower($v); return $this; }
    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(?string $v): self { $this->phone=$v; return $this; }
    public function getCompany(): ?string { return $this->company; }
    public function setCompany(?string $v): self { $this->company=$v; return $this; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function getOrders(): Collection { return $this->orders; }
}
