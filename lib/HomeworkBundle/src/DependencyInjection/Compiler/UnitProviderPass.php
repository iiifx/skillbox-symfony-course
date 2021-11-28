<?php

declare(strict_types=1);

namespace SymfonySkillbox\HomeworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class UnitProviderPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('symfony_skillbox_homework.unit_factory')) {
            return;
        }

        $taggedProviders = $container->findTaggedServiceIds('symfony_skillbox_homework.unit_provider');

        $references = [];
        foreach ($taggedProviders as $id => $tags) {
            $references[] = new Reference($id);
        }

        if (empty($references)) {
            $references[] = new Reference('symfony_skillbox_homework.unit_provider');
        }

        $definition = $container->findDefinition('symfony_skillbox_homework.unit_factory');
        $definition->setArgument(1, $references);
    }
}
