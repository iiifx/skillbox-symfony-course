<?php

declare(strict_types=1);

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ExampleEventListener
{
    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    public function onEvent(Event $event): void
    {
        $this->logger->info(sprintf('Произошло событие %s', __METHOD__));
    }
}
