<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 */
class ArticlesController extends AbstractController
{
    #[Route('/admin/articles/create', name: 'app_admin_article_create')]
    #[IsGranted('ROLE_ADMIN_ARTICLE')]
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return new Response('...');
    }

    #[Route('/admin/articles/{id}/edit', name: 'app_admin_article_edit')]
    #[IsGranted('MANAGE', subject: 'article')]
    public function edit(Request $request, Article $article)
    {
        //$this->denyAccessUnlessGranted('MANAGE', $article);

        return new Response('...');
    }
}
