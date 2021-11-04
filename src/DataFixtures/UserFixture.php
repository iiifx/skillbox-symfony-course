<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends BaseFixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function loadData(ObjectManager $manager): void
    {
        $this->createOne(User::class, function (User $user) {
            $user->setEmail('admin@symfony.skillbox');
            $user->setFirstName('Admin');
            $user->setIsActive(true);
            $user->setRoles(['ROLE_ADMIN']);

            // hash the password (based on the security.yaml config for the $user class)
            $user->setPassword($this->passwordHasher->hashPassword($user, '123456'));
        });

        $this->createOne(User::class, function (User $user) {
            $user->setEmail('api@symfony.skillbox');
            $user->setFirstName('Api');
            $user->setIsActive(true);
            $user->setRoles(['ROLE_API']);

            // hash the password (based on the security.yaml config for the $user class)
            $user->setPassword($this->passwordHasher->hashPassword($user, '123456'));
        });

        $this->createMany(User::class, 10, function (User $user) {
            $user->setEmail($this->faker->email);
            $user->setFirstName($this->faker->firstName);

            $user->setIsActive($this->faker->boolean(70));

            // hash the password (based on the security.yaml config for the $user class)
            $user->setPassword($this->passwordHasher->hashPassword($user, '123456'));
        });
    }
}
