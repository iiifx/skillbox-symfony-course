<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/admin/article/create', name: 'app_admin_article_create')]
    public function create(EntityManagerInterface $em): Response
    {
        $article = new Article();

        $article->setTitle('Article title');
        $article->setSlug('article-slug-' . random_int(100, 999));
        $article->setBody(
            '- Lorem **ipsum** dolor sit amet, ~~consectetur~~ adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Purus sit amet luctus venenatis lectus magna fringilla urna porttitor. Sit amet cursus sit amet. Mattis molestie a iaculis at erat. Quis auctor elit sed vulputate mi. Vulputate dignissim suspendisse in est ante in nibh. Sed augue lacus viverra vitae. At in tellus integer feugiat scelerisque varius morbi. Tortor at risus viverra adipiscing at in. Rhoncus urna neque viverra justo nec ultrices.',
        );

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
