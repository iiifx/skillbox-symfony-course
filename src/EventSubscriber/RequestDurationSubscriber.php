<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Contracts\EventDispatcher\Event;

class RequestDurationSubscriber implements EventSubscriberInterface
{
    private float $start;

    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    public function startTimer(Event $event): void
    {
        $this->start = microtime(true);
    }

    public function endTimer(Event $event): void
    {
        $ms = (microtime(true) - $this->start) * 1000;

        $this->logger->info(sprintf('Длительность выполнения %d ms', $ms));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => ['startTimer', 100],
            ResponseEvent::class => [
                ['endTimer', 0],
            ],
        ];
    }
}
