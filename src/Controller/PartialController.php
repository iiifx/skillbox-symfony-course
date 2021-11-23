<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class PartialController extends AbstractController
{
    public function forSubQuery(HttpKernelInterface $httpKernel)
    {
        $request = new Request();
        $request->attributes->set('_controller', 'App\\Controller\\PartialController::latestComments');

        $response = $httpKernel->handle($request, HttpKernelInterface::SUB_REQUEST);
        $comments = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        return $this->render('_partial/latest_comments.html.twig', [
            'latestComments' => $comments,
        ]);
    }

    public function latestComments(CommentRepository $commentRepository)
    {
        $comments = $commentRepository->findLatestPublished(4);

        return $this->json($comments, context: ['groups' => 'latestComments']);
    }
}
