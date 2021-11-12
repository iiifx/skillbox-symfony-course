<?php

namespace App\Form;

use App\Entity\User;
use App\Homework\RegistrationSpamFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class UserRegistrationFormType extends AbstractType
{
    public function __construct(
        protected RegistrationSpamFilter $spamFilter
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Callback(
                        function ($email, ExecutionContextInterface $context, $payload) {
                            if ($this->spamFilter->filter($email)) {
                                $context->buildViolation('Ботам здесь не место')
                                    ->atPath('email')
                                    ->addViolation();
                            }
                        }
                    )
                ]
            ])
            ->add('firstName')
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Пароль не указан'
                    ]),
                    new Length([
                        'min' => 6,
                    ])
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Необходимо согласиться с правилами',
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
