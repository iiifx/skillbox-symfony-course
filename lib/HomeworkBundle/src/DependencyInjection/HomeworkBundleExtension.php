<?php

declare(strict_types=1);

namespace SymfonySkillbox\HomeworkBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

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

            // @see \SymfonySkillbox\HomeworkBundle\DependencyInjection\Compiler\UnitProviderPass::process
        }
    }

    public function getAlias(): string
    {
        return self::ALIAS;
    }
}
