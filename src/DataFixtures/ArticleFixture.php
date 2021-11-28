<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tag;
use App\Entity\User;
use App\Service\FileUploader;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;

class ArticleFixture extends BaseFixture implements DependentFixtureInterface
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

    public function __construct(
        protected FileUploader $articleFileUploader
    ) {
    }


    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Article::class, 25, function (Article $article) {
            $paragraphs = $this->faker->numberBetween(2, 10);
            $wordParams = $this->faker->boolean(70) ? ['WORD', 5] : [];
            $content = $this->articleContentProvider->get($paragraphs, ...$wordParams);

            $article->setBody($content);
            $article->setTitle($this->faker->randomElement($this->articleTitles));

            //$article->setSlug(sprintf('article-slug-%d', $this->faker->numberBetween(1, 100000)));
            $article->setDescription($this->faker->words(3, true));

            $article->setAuthor($this->getRandomReference(User::class));
            $article->setLikeCount($this->faker->numberBetween(-10, 100));

            $filePath = sprintf(
                '%s/public/images/%s',
                dirname(__DIR__, 2),
                $this->faker->randomElement($this->articleImages)
            );

            $filename = $this->articleFileUploader->uploadFile(new File($filePath));

            $article->setImageFilename($filename);

            if ($this->faker->boolean(70)) {
                $article->setPublishedAt(
                    DateTimeImmutable::createFromMutable(
                        $this->faker->dateTimeBetween('-100 days', '-1 days')
                    )
                );
            }

            for ($i = 0; $i < $this->faker->numberBetween(0, 5); $i++) {
                $article->addTag($this->getRandomReference(Tag::class));
            }
        });
    }

    public function getDependencies(): array
    {
        return [
            TagFixture::class,
            UserFixture::class,
        ];
    }
}
