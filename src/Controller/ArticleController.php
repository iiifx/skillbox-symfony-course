<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {
        return $this->render('articles/homepage.html.twig', [
            'articles' => $repository->findLatestPublished(),
        ]);
    }

    /**
     * @Route("/articles/{slug}", name="app_article_show")
     */
    public function show(Article $article)
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article,
        ]);
    }
}
