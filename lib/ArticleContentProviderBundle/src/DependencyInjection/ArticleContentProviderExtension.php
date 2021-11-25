<?php

declare(strict_types=1);

namespace SkillboxSymfony\ArticleContentProviderBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class ArticleContentProviderExtension extends Extension
{
    public const ALIAS = 'skillbox_article_content_provider';

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Resources/config'));
        $loader->load('services.xml');

        if ($configuration = $this->getConfiguration($configs, $container)) {
            $config = $this->processConfiguration($configuration, $configs);

            $definition = $container->getDefinition('skillbox.article_content_provider');
            $definition->setArgument(1, $config['is_bold']);
        }
    }

    public function getAlias(): string
    {
        return self::ALIAS;
    }
}
