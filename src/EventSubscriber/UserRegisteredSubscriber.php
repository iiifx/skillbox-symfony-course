<?php

namespace App\EventSubscriber;

use App\Events\UserRegisteredEvent;
use App\Service\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserRegisteredSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected Mailer $mailer
    ) {
    }

    public function sendEmail(UserRegisteredEvent $event): void
    {
        $this->mailer->sendWelcome($event->getUser());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserRegisteredEvent::class => 'sendEmail',
        ];
    }
}
