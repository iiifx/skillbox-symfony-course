<?php

declare(strict_types=1);

namespace App\Homework;

interface ArticleContentProviderInterface
{
    public function get(int $paragraphs, string $word = null, int $wordsCount = 0): string;
}
