<?php

declare(strict_types=1);

namespace SkillboxSymfony\ArticleContentProviderBundle;

interface WordDecoratorInterface
{
    public function decorate(string $word, bool $isBold): string;
}
