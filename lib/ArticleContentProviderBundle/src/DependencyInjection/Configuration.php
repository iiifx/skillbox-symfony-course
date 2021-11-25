<?php

declare(strict_types=1);

namespace SkillboxSymfony\ArticleContentProviderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(ArticleContentProviderExtension::ALIAS);
        $children = $treeBuilder->getRootNode()->children();

        $children->booleanNode('is_bold')->defaultTrue()->info('Bold or Italic word style');

        return $treeBuilder;
    }
}
