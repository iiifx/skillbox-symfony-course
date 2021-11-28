<?php

declare(strict_types=1);

namespace App\Entity\Article;

class Article implements ArticleInterface
{
    protected string $title;
    protected string $slug;
    protected string $image;
    protected string $content;

    public static function create(string $slug, string $title, string $image, string $content): static
    {
        $article = new static();
        $article->slug = $slug;
        $article->title = $title;
        $article->image = $image;
        $article->content = $content;

        return $article;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
