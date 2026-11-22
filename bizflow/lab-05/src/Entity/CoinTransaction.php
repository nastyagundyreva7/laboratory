<?php
declare(strict_types=1);
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]
#[ORM\Table(name:'coin_transaction',indexes:[new ORM\Index(name:'idx_coin_tx_wallet_date',columns:['wallet_id','created_at'])])]
class CoinTransaction {
 #[ORM\Id,ORM\GeneratedValue,ORM\Column] private ?int $id=null;
 #[ORM\ManyToOne(targetEntity:Wallet::class,inversedBy:'transactions')] #[ORM\JoinColumn(name:'wallet_id',nullable:false,onDelete:'CASCADE')] private Wallet $wallet;
 #[ORM\Column(length:8)] private string $type;
 #[ORM\Column(type:'integer')] private int $amount;
 #[ORM\Column(length:255)] private string $description;
 #[ORM\Column(name:'created_at',type:'datetime_immutable')] private \DateTimeImmutable $createdAt;
 public function __construct(Wallet $wallet,string $type,int $amount,string $description){if(!in_array($type,['earn','spend'],true)||$amount<=0)throw new \InvalidArgumentException();$this->wallet=$wallet;$this->type=$type;$this->amount=$amount;$this->description=$description;$this->createdAt=new \DateTimeImmutable();}
 public function getId():?int{return $this->id;}public function getType():string{return $this->type;}public function getAmount():int{return $this->amount;}public function getDescription():string{return $this->description;}public function getCreatedAt():\DateTimeImmutable{return $this->createdAt;}
}
