<?php
declare(strict_types=1);
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity]
#[ORM\Table(name:'student',uniqueConstraints:[new ORM\UniqueConstraint(name:'uniq_student_email',columns:['email'])])]
class Student {
 #[ORM\Id,ORM\GeneratedValue,ORM\Column] private ?int $id=null;
 #[ORM\Column(length:120)] #[Assert\NotBlank,Assert\Length(max:120)] private string $name;
 #[ORM\Column(length:180)] #[Assert\NotBlank,Assert\Email] private string $email;
 #[ORM\Column(length:160)] private string $faculty;
 #[ORM\Column(length:160)] private string $program;
 #[ORM\Column(name:'created_at',type:'datetime_immutable')] private \DateTimeImmutable $createdAt;
 #[ORM\OneToOne(mappedBy:'student',targetEntity:Wallet::class,cascade:['persist','remove'])] private ?Wallet $wallet=null;
 public function __construct(string $name,string $email,string $faculty,string $program){$this->name=$name;$this->email=mb_strtolower($email);$this->faculty=$faculty;$this->program=$program;$this->createdAt=new \DateTimeImmutable();}
 public function getId():?int{return $this->id;} public function getName():string{return $this->name;} public function getEmail():string{return $this->email;} public function getFaculty():string{return $this->faculty;} public function getProgram():string{return $this->program;} public function getCreatedAt():\DateTimeImmutable{return $this->createdAt;} public function getWallet():?Wallet{return $this->wallet;} public function setWallet(Wallet $wallet):self{$this->wallet=$wallet;return $this;}
}
