<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use LogicException;
use SkillboxSymfony\ArticleContentProviderBundle\ArticleContentProvider;
use SkillboxSymfony\ArticleContentProviderBundle\CommentContentProvider;

abstract class BaseFixture extends Fixture
{
    protected ArticleContentProvider $articleContentProvider;
    protected CommentContentProvider $commentContentProvider;
    protected Generator $faker;
    protected ObjectManager $manager;

    protected array $referenceObjects = [];

    /**
     * @required
     */
    public function setProviders(
        ArticleContentProvider $articleContentProvider,
        CommentContentProvider $commentContentProvider
    ): void {
        $this->articleContentProvider = $articleContentProvider;
        $this->commentContentProvider = $commentContentProvider;
    }

    abstract public function loadData(ObjectManager $manager): void;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create('ru_RU');
        $this->manager = $manager;

        $this->loadData($manager);

        $manager->flush();
    }

    protected function createOne(string $class, callable $factory): object
    {
        $entity = new $class();
        $factory($entity);

        $this->manager->persist($entity);

        return $entity;
    }

    protected function createMany(string $class, int $count, callable $factory): void
    {
        while ($count--) {
            $entity = $this->createOne($class, $factory);

            $this->setReference("$class|$count", $entity);
        }
    }

    protected function getRandomReference(string $class): object
    {
        if (!isset($this->referenceObjects[$class])) {
            $this->referenceObjects[$class] = [];

            foreach ($this->referenceRepository->getReferences() as $name => $object) {
                if (str_starts_with($name, "$class|")) {
                    $this->referenceObjects[$class][] = $name;
                }
            }
        }

        if (empty($this->referenceObjects[$class])) {
            throw new LogicException(sprintf('Refference for %s not found', $class));
        }

        return $this->getReference($this->faker->randomElement($this->referenceObjects[$class]));
    }
}
