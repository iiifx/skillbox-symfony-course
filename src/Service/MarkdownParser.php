<?php

declare(strict_types=1);

namespace App\Service;

use Demontpx\ParsedownBundle\Parsedown;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownParser
{
    protected Parsedown $parsedown;
    protected AdapterInterface $cache;
    protected LoggerInterface $logger;

    public function __construct(Parsedown $parsedown, AdapterInterface $cache, LoggerInterface $logger)
    {
        $this->parsedown = $parsedown;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    public function parse(string $content): string
    {
        if (stripos($content, 'lorem') !== false) {
            $this->logger->info('Lorem found!');
        }

        return $this->cache->get(
            sprintf('article-%s', md5($content)),
            function () use ($content) {
                return $this->parsedown->parse($content);
            }
        );
    }
}
