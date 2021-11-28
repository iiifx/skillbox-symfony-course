<?php

declare(strict_types=1);

namespace SkillboxSymfony\ArticleContentProviderBundle;

use SkillboxSymfony\ArticleContentProviderBundle\DependencyInjection\ArticleContentProviderExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ArticleContentProviderBundle extends Bundle
{
    public function getContainerExtension()
    {
        return $this->extension ??= new ArticleContentProviderExtension();
    }
}
