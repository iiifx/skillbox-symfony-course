<?php

declare(strict_types=1);

namespace SkillboxSymfony\ArticleContentProviderBundle;

interface ArticleContentProviderInterface
{
    public function get(int $paragraphs, string $word = null, int $wordsCount = 0): string;
}
