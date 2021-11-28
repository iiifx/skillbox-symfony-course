<?php

declare(strict_types=1);

namespace SymfonySkillbox\HomeworkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(HomeworkBundleExtension::ALIAS);
        $children = $treeBuilder->getRootNode()->children();

        $children
            ->scalarNode('strategy')
                ->defaultNull()
                ->info('Current unit strategy');
        // $children
        //     ->arrayNode('unit_providers')
        //         ->requiresAtLeastOneElement()
        //         ->info('Unit provider list')
        //         ->useAttributeAsKey('name')
        //         ->prototype('scalar');

        return $treeBuilder;
    }
}
