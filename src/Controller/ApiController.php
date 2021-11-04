<?php

namespace App\Controller;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method User|null getUser()
 */
class ApiController extends AbstractController
{
    #[Route('/api/v1/article_content', name: 'app_api_v1_article_content')]
    public function index(LoggerInterface $apiLogger): Response
    {
        if (!$this->isGranted('ROLE_API')) {
            $apiLogger->warning('Wrong user access', [
                'user' => $this->getUser()?->getEmail()
            ]);
        }

        return $this->json([
            // ...
        ]);
    }
}
