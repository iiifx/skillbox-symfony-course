<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('Homepage');
    }

    /**
     * @Route("/articles/{slug}")
     */
    public function show(string $slug)
    {
        return new Response(
            sprintf(
                'Article: %s',
                ucwords(str_replace('-', ' ', $slug))
            )
        );
    }
}
