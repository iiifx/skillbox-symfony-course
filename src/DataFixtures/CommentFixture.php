<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixture extends BaseFixtures implements DependentFixtureInterface
{
    protected array $articleAuthors = [
        'Lorem ipsum',
        'Consectetur',
        'Tempor incididunt',
        'Ut enim',
        'Ullamco',
        'Duis aute',
        'Velit',
        'Excepteur sint',
        'Sunt in culpa',
        'Mollit',
    ];

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Comment::class, 500, function (Comment $comment) {
            $wordParams = $this->faker->boolean(70) ? ['WORD', $this->faker->numberBetween(1, 5)] : [];

            $comment
                ->setAuthorName($this->faker->randomElement($this->articleAuthors))
                ->setContent($this->commentContentProvider->get(... $wordParams))
                ->setCreatedAt(
                    DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
                )
                ->setArticle($this->getRandomReference(Article::class));

            if ($this->faker->boolean()) {
                $comment->setDeletedAt(new DateTimeImmutable());
            }

            $this->manager->persist($comment);
        });
    }

    public function getDependencies(): array
    {
        return [
            ArticleFixtures::class,
        ];
    }
}
