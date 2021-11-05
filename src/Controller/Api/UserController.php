<?php

namespace App\Controller\Api;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 *
 * @method User|null getUser()
 */
class UserController extends AbstractController
{
    #[Route('/api/v1/user', name: 'app_api_v1_user')]
    public function index(Request $request, LoggerInterface $apiLogger): Response
    {
        $apiLogger->info('Access', [
            // какой пользователь авторизовался;
            'user' => $this->getUser()?->getEmail(),
            // под каким токеном
            'token' => $request->headers->get('Authorization'),
            // имя исполняемого маршрута
            'route' => $request->get('_route'),
            // url запроса
            'url' => $request->getRequestUri(),
        ]);

        return $this->json([
            'user' => $this->getUser(),
        ], context: ['groups' => 'main']);
    }
}
