<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    protected ArticleRepository $articles;
    protected CommentRepository $comments;

    public function __construct(ArticleRepository $articles, CommentRepository $comments)
    {
        $this->articles = $articles;
        $this->comments = $comments;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('articles/homepage.html.twig', [
            'articles' => $this->articles->findLatestPublished(),
            'latestComments' => $this->comments->findLatestPublished(3),
        ]);
    }

    /**
     * @Route("/articles/{slug}", name="app_article_show")
     */
    public function show(string $slug)
    {
        if (!$article = $this->articles->findBySlug($slug)) {
            throw $this->createNotFoundException();
        }

        return $this->render('articles/show.html.twig', [
            'article' => $article,
        ]);
    }
}
