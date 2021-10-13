<?php

declare(strict_types=1);

namespace App\Entity;

class Article
{
    protected string $title;
    protected string $slug;
    protected string $image;

    public static function create(string $slug, string $title, string $image): static
    {
        $article = new static();
        $article->slug = $slug;
        $article->title = $title;
        $article->image = $image;

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
}
