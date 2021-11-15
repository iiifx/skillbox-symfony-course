<?php

namespace App\Form\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationDTO
{
    #[Assert\NotBlank(message: 'Почта не указана')]
    #[Assert\Email()]
    public ?string $email = null;

    public ?string $firstName = null;

    #[Assert\NotBlank(message: 'Пароль не указан')]
    #[Assert\Length(min: 6)]
    public ?string $plainPassword = null;

    #[Assert\IsTrue(message: 'Необходимо согласиться с правилам')]
    public bool $agreeTerms = false;
}
