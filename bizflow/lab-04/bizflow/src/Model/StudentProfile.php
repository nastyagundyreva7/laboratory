<?php
declare(strict_types=1);
namespace App\Model;
use Symfony\Component\Validator\Constraints as Assert;
final class StudentProfile {
 public function __construct(
  #[Assert\NotBlank(message:'Укажите имя.'), Assert\Length(max:120)] public string $name='',
  #[Assert\NotBlank(message:'Укажите учебную почту.'), Assert\Email(message:'Введите корректный email.'), Assert\Length(max:180)] public string $email='',
  #[Assert\NotBlank(message:'Укажите факультет или институт.'), Assert\Length(max:160)] public string $faculty='',
  #[Assert\NotBlank(message:'Укажите направление подготовки.'), Assert\Length(max:160)] public string $program='',
  #[Assert\Length(max:500)] public string $about=''
 ) {}
}
