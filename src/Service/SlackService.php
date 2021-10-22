<?php

declare(strict_types=1);

namespace App\Service;

use Nexy\Slack\Client;
use Psr\Log\LoggerInterface;

class SlackService
{
    protected Client $client;
    protected LoggerInterface $logger;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @required
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    public function sendMessage(string $text, string $author = 'Bot', string $icon = ':ghost:'): void
    {
        $this->logger?->info($text);

        //$client = $this->get('nexy_slack.client');
        $message = $this->client->createMessage();

        $message
            //->to('#test')
            ->from($author)
            ->withIcon($icon)
            ->setText($text);

        //$message->attach((new Attachment())
        //    ->setFallback('Some fallback text')
        //    ->setText('The attachment text')
        //);

        $this->client->sendMessage($message);
    }
}
