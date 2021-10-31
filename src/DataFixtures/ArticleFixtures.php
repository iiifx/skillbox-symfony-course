<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixtures
{
    protected array $articleTitles = [
        'Lorem ipsum dolor sit amet',
        'Consectetur adipiscing elit, sed do eiusmod',
        'Tempor incididunt ut labore et dolore magna aliqua',
        'Ut enim ad minim veniam, quis nostrud exercitation',
        'Ullamco laboris nisi ut aliquip ex ea commodo consequat',
        'Duis aute irure dolor in reprehenderit in voluptate',
        'Velit esse cillum dolore eu fugiat nulla pariatur',
        'Excepteur sint occaecat cupidatat non proident',
        'Sunt in culpa qui officia deserunt',
        'Mollit anim id est laborum',
    ];
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
    protected array $articleImages = [
        'dogs/01.jpg',
        'dogs/02.jpg',
        'dogs/03.jpg',
        'dogs/04.jpg',
        'dogs/05.jpg',
        'dogs/06.jpg',
        'dogs/07.jpg',
        'dogs/08.jpg',
    ];

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Article::class, 50, function (Article $article) {
            $paragraphs = $this->faker->numberBetween(2, 10);
            $wordParams = $this->faker->boolean(70) ? ['WORD', 5] : [];
            $content = $this->articleContentProvider->get($paragraphs, ...$wordParams);

            $article->setBody($content);
            $article->setTitle($this->faker->randomElement($this->articleTitles));

            //$article->setSlug(sprintf('article-slug-%d', $this->faker->numberBetween(1, 100000)));
            $article->setDescription($this->faker->words(3, true));

            $article->setAuthor($this->faker->randomElement($this->articleAuthors));
            $article->setLikeCount($this->faker->numberBetween(-10, 100));
            $article->setImageFilename($this->faker->randomElement($this->articleImages));

            if ($this->faker->boolean(70)) {
                $article->setKeywords($this->faker->words($this->faker->numberBetween(2, 6)));
            }
            if ($this->faker->boolean(70)) {
                $article->setPublishedAt(
                    DateTimeImmutable::createFromMutable(
                        $this->faker->dateTimeBetween('-100 days', '-1 days')
                    )
                );
            }

            $this->createMany(
                Comment::class,
                $this->faker->numberBetween(2, 10),
                function (Comment $comment) use ($article) {
                    $wordParams = $this->faker->boolean(70) ? ['WORD', $this->faker->numberBetween(1, 5)] : [];

                    $comment
                        ->setAuthorName($this->faker->randomElement($this->articleAuthors))
                        ->setContent($this->commentContentProvider->get(... $wordParams))
                        ->setCreatedAt(
                            DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
                        )
                        ->setArticle($article);

                    if ($this->faker->boolean()) {
                        $comment->setDeletedAt(new DateTimeImmutable());
                    }

                    $this->manager->persist($comment);
                }
            );
        });
    }
}
