<?php

declare(strict_types=1);

namespace App\Entity\Article;

interface ArticleInterface
{
    public function getTitle(): string;

    public function getSlug(): string;

    public function getImage(): string;

    public function getContent(): string;
}
