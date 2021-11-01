<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(User::class, 10, function (User $user) {
            $user->setEmail($this->faker->email);
            $user->setFirstName($this->faker->firstName);
            $user->setPassword('123456');
        });
    }
}
