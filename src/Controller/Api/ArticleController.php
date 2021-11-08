<?php

namespace App\Controller\Api;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/api/v1/articles/{id}', name: 'app_api_v1_article')]
    #[IsGranted('API_ARTICLE', subject: 'article')]
    public function index(Article $article)
    {
        return $this->json([
            'article' => $article,
        ], context: ['groups' => 'api']);
    }
}
