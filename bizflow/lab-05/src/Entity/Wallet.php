<?php
declare(strict_types=1);
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;use Doctrine\Common\Collections\Collection;use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]
#[ORM\Table(name:'wallet')]
class Wallet {
 #[ORM\Id,ORM\GeneratedValue,ORM\Column] private ?int $id=null;
 #[ORM\OneToOne(inversedBy:'wallet',targetEntity:Student::class)] #[ORM\JoinColumn(name:'student_id',nullable:false,unique:true,onDelete:'CASCADE')] private Student $student;
 #[ORM\Column(type:'integer',options:['default'=>0])] private int $balance=0;
 #[ORM\Column(name:'created_at',type:'datetime_immutable')] private \DateTimeImmutable $createdAt;
 /** @var Collection<int,CoinTransaction> */ #[ORM\OneToMany(mappedBy:'wallet',targetEntity:CoinTransaction::class,cascade:['persist'])] private Collection $transactions;
 public function __construct(Student $student){$this->student=$student;$this->createdAt=new \DateTimeImmutable();$this->transactions=new ArrayCollection();$student->setWallet($this);}
 public function getId():?int{return $this->id;} public function getStudent():Student{return $this->student;} public function getBalance():int{return $this->balance;} public function getTransactions():Collection{return $this->transactions;}
 public function apply(int $amount,string $type,string $description):CoinTransaction{if(!in_array($type,['earn','spend'],true)||$amount<=0)throw new \InvalidArgumentException('Некорректная операция с RDC.');if($type==='spend'&&$amount>$this->balance)throw new \DomainException('Недостаточно RDC на балансе.');$this->balance += $type==='earn'?$amount:-$amount;$tx=new CoinTransaction($this,$type,$amount,$description);$this->transactions->add($tx);return $tx;}
}
