<?php

declare(strict_types=1);

namespace SkillboxSymfony\ArticleContentProviderBundle;

interface ComentContentProviderInterface
{
    public function get(string $word = null, int $wordsCount = 0): string;
}
