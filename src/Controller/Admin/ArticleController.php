<?php

namespace App\Controller\Admin;

use App\Service\ArticleContentProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/admin/articles/create', name: 'app_admin_article_create')]
    public function create(EntityManagerInterface $em, ArticleContentProvider $provider): Response
    {
        return $this->json([]);
    }
}
