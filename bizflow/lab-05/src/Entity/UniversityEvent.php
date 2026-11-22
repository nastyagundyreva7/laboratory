<?php
declare(strict_types=1);
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity]
#[ORM\Table(name:'university_event',indexes:[new ORM\Index(name:'idx_event_date',columns:['starts_at'])])]
class UniversityEvent {
 #[ORM\Id,ORM\GeneratedValue,ORM\Column] private ?int $id=null;
 #[ORM\Column(length:180)] #[Assert\NotBlank] private string $title;
 #[ORM\Column(type:'text')] private string $description;
 #[ORM\Column(name:'starts_at',type:'datetime_immutable')] private \DateTimeImmutable $startsAt;
 #[ORM\Column(type:'integer')] private int $rewardCoins;
 public function __construct(string $title,string $description,\DateTimeImmutable $startsAt,int $rewardCoins){if($rewardCoins<0)throw new \InvalidArgumentException();$this->title=$title;$this->description=$description;$this->startsAt=$startsAt;$this->rewardCoins=$rewardCoins;}
 public function getId():?int{return $this->id;}public function getTitle():string{return $this->title;}public function getDescription():string{return $this->description;}public function getStartsAt():\DateTimeImmutable{return $this->startsAt;}public function getRewardCoins():int{return $this->rewardCoins;}
}
