<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Service\ArticleContentProvider;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/admin/articles/create', name: 'app_admin_article_create')]
    public function create(EntityManagerInterface $em, ArticleContentProvider $provider): Response
    {
        $article = new Article();

        $paragraphs = random_int(2, 10);
        $wordParams = random_int(1, 10) >= 7 ? ['WORD', 5] : [];
        $content = $provider->get($paragraphs, ...$wordParams);

        $article->setBody($content);
        $article->setTitle('Article title');
        $article->setSlug('article-slug-' . random_int(100, 999));
        $article->setDescription('Sit amet cursus sit amet. Mattis molestie a iaculis at erat');

        $article->setAuthor('Author');
        $article->setLikeCount(random_int(-99, 99));
        $article->setImageFilename('car1.jpg');

        if (random_int(1, 10) <= 6) {
            $article->setKeywords([
                'One',
                'Two',
                'Three',
            ]);
        }
        if (random_int(1, 10) <= 6) {
            $article->setPublishedAt(
                new DateTimeImmutable(
                    sprintf('-%d days', random_int(1, 60))
                )
            );
        }

        $em->persist($article);
        $em->flush();

        return $this->json([
            $article->getTitle(),
            $article->getSlug(),
            $article->getBody(),
            $article->getPublishedAt(),
        ]);
    }
}
