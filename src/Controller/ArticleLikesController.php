<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleLikesController extends AbstractController
{
    /**
     * @Route("/articles/{articleId<\d+>}/likes", name="app_article_like_change", methods={"PUT","DELETE"})
     */
    public function change(string $articleId, Request $request, LoggerInterface $logger)
    {
        $likes = match ($request->getMethod()) {
            Request::METHOD_PUT => 1,
            Request::METHOD_DELETE => 0,

            default => throw new BadRequestHttpException('Bad request'),
        };

        return $this->json(['likes' => $likes]);
    }
}
