<?php

declare(strict_types=1);

namespace App\Service;

use Nexy\Slack\Client;

class SlackService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function sendMessage(string $text, string $author = 'Bot', string $icon = ':ghost:'): void
    {
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
