<?php

declare(strict_types=1);

namespace App\Service;

use SkillboxSymfony\ArticleContentProviderBundle\WordDecoratorInterface;

class RedHtmlWordDecorator implements WordDecoratorInterface
{
    public function decorate(string $word, bool $isBold): string
    {
        if ($isBold) {
            return '<strong style="color: red;">' . $word . '</strong>';
        }

        return '<i style="color: red;">' . $word . '</i>';
    }
}
