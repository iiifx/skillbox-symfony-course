<?php

declare(strict_types=1);

namespace App\Entity\Article;

use Demontpx\ParsedownBundle\Parsedown;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class ArticleParseDecorator implements ArticleInterface
{
    protected ArticleInterface $article;
    protected Parsedown $parsedown;
    protected ?AdapterInterface $cache;

    public function __construct(ArticleInterface $article, Parsedown $parsedown, AdapterInterface $cache = null)
    {
        $this->article = $article;
        $this->parsedown = $parsedown;
        $this->cache = $cache;
    }

    public function getTitle(): string
    {
        return $this->article->getTitle();
    }

    public function getSlug(): string
    {
        return $this->article->getSlug();
    }

    public function getImage(): string
    {
        return $this->article->getImage();
    }

    public function getContent(): string
    {
        $content = $this->article->getContent();

        if (null !== $this->cache) {
            return $this->cache->get(
                sprintf('article-%s-%s', $this->article->getSlug(), md5($content)),
                function () use ($content) {
                    return $this->parsedown->parse($content);
                }
            );
        }

        return $this->parsedown->parse($content);
    }
}
