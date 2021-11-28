<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleLikesController extends AbstractController
{
    /**
     * @Route("/articles/{slug<(\w|-)+>}/likes", name="app_article_like_change", methods={"PUT","DELETE"})
     */
    public function change(Article $article, Request $request, EntityManagerInterface $em)
    {
        if ($request->getMethod() === Request::METHOD_PUT) {
            $article->addLike();
        } elseif ($request->getMethod() === Request::METHOD_DELETE) {
            $article->removeLike();
        } else {
            throw new BadRequestHttpException('Bad request');
        }

        $em->flush();

        return $this->json(['likes' => $article->getLikeCount()]);
    }
}
