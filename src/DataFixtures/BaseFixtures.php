<?php

namespace App\DataFixtures;

use App\Service\ArticleContentProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixtures extends Fixture
{
    protected ArticleContentProvider $articleContentProvider;
    protected Generator $faker;
    protected ObjectManager $manager;

    /**
     * @required
     */
    public function setArticleContentProvider(ArticleContentProvider $articleContentProvider): void
    {
        $this->articleContentProvider = $articleContentProvider;
    }

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create('ru_RU');
        $this->manager = $manager;

        $this->loadData($manager);

        $manager->flush();
    }

    protected function createOne(string $class, callable $factory): void
    {
        $entity = new $class();
        $factory($entity);

        $this->manager->persist($entity);
    }

    protected function createMany(string $class, int $count, callable $factory): void
    {
        while ($count--) {
            $this->createOne($class, $factory);
        }
    }

    abstract public function loadData(ObjectManager $manager): void;
}
