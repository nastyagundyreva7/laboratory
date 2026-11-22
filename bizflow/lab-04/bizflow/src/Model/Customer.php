<?php
declare(strict_types=1);
namespace App\Model;
use Symfony\Component\Validator\Constraints as Assert;
final class Customer
{
    public function __construct(
        #[Assert\NotBlank(message: 'Укажите имя клиента.')]
        #[Assert\Length(max: 120, maxMessage: 'Имя не должно превышать {{ limit }} символов.')]
        public string $name = '',
        #[Assert\NotBlank(message: 'Укажите email.')]
        #[Assert\Email(message: 'Введите корректный email.')]
        #[Assert\Length(max: 180)]
        public string $email = '',
        #[Assert\Length(max: 30, maxMessage: 'Телефон не должен превышать {{ limit }} символов.')]
        public string $phone = '',
        #[Assert\Length(max: 120, maxMessage: 'Название компании не должно превышать {{ limit }} символов.')]
        public string $company = '',
        #[Assert\Length(max: 1000, maxMessage: 'Комментарий не должен превышать {{ limit }} символов.')]
        public string $comment = '',
        public ?int $id = null,
    ) {}
}
