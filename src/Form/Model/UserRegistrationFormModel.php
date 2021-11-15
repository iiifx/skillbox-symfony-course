<?php

namespace App\Form\Model;

use App\Validator\RegistrationSpam;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\UniqueUser;

class UserRegistrationFormModel
{
    #[Assert\NotBlank(message: 'Почта не указана')]
    #[Assert\Email()]
    #[UniqueUser()]
    #[RegistrationSpam(message: 'Ваш e-mail не одобрен спам-фильтром')]
    public ?string $email = null;

    public ?string $firstName = null;

    #[Assert\NotBlank(message: 'Пароль не указан')]
    #[Assert\Length(min: 6)]
    public ?string $plainPassword = null;

    #[Assert\IsTrue(message: 'Необходимо согласиться с правилами')]
    public bool $agreeTerms = false;
}
