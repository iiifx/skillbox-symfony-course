<?php

declare(strict_types=1);

namespace SkillboxSymfony\ArticleContentProviderBundle;

class MarkdownWordDecorator implements WordDecoratorInterface
{
    public function decorate(string $word, bool $isBold): string
    {
        return $isBold ? "**$word**" : "_{$word}_";
    }
}
