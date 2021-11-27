<?php

declare(strict_types=1);

namespace SymfonySkillbox\HomeworkBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class HomeworkBundleExtension extends Extension
{
    public const ALIAS = 'symfony_skillbox_homework';

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Resources/config'));
        $loader->load('services.xml');

        if ($configuration = $this->getConfiguration($configs, $container)) {
            $config = $this->processConfiguration($configuration, $configs);

            if (isset($config['strategy'])) {
                $container->setAlias('symfony_skillbox_homework.strategy', $config['strategy']);
            }

            $definition = $container->getDefinition('symfony_skillbox_homework.unit_factory');
            if (empty($config['unit_providers'])) {
                # Задаем дефолтный юнит-провайдер: base_provider
                $definition->setArgument(1, [new Reference('symfony_skillbox_homework.unit_provider')]);
            } else {
                $references = [];
                foreach ($config['unit_providers'] as $ID) {
                    $references[] = new Reference($ID);
                }
                $definition->setArgument(1, $references);
            }
        }
    }

    public function getAlias(): string
    {
        return self::ALIAS;
    }
}
