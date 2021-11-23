<?php

namespace App\EventSubscriber;

use App\Events\ArticleCreatedEvent;
use App\Service\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ArticleCreatedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected Mailer $mailer,
        protected AuthorizationCheckerInterface $checker
    ) {
    }

    public function sendEmail(ArticleCreatedEvent $event): void
    {
        $article = $event->getArticle();

        if (!$this->checker->isGranted('ROLE_ADMIN', $article->getAuthor())) {
            $this->mailer->sendAdminNotice($article);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ArticleCreatedEvent::class => 'sendEmail',
        ];
    }
}
