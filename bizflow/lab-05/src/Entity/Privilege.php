<?php
declare(strict_types=1);
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]
#[ORM\Table(name:'privilege')]
class Privilege {
 #[ORM\Id,ORM\GeneratedValue,ORM\Column] private ?int $id=null;
 #[ORM\Column(length:160)] private string $title;
 #[ORM\Column(type:'text')] private string $description;
 #[ORM\Column(type:'integer')] private int $costCoins;
 #[ORM\Column(type:'boolean')] private bool $active=true;
 public function __construct(string $title,string $description,int $costCoins){if($costCoins<=0)throw new \InvalidArgumentException();$this->title=$title;$this->description=$description;$this->costCoins=$costCoins;}
 public function getId():?int{return $this->id;}public function getTitle():string{return $this->title;}public function getDescription():string{return $this->description;}public function getCostCoins():int{return $this->costCoins;}public function isActive():bool{return $this->active;}
}
