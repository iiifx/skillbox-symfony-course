<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;

class TagFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Tag::class, 100, function (Tag $tag) {
            $tag->setName($this->faker->realText(15));
            $tag->setCreatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );

            if ($this->faker->boolean(20)) {
                $tag->setDeletedAt(new DateTimeImmutable());
            }
        });
    }
}
