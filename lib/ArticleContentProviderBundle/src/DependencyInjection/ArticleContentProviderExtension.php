<?php

declare(strict_types=1);

namespace SkillboxSymfony\ArticleContentProviderBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class ArticleContentProviderExtension extends Extension
{
    public const ALIAS = 'skillbox_article_content_provider';

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Resources/config'));
        $loader->load('services.xml');

        if ($configuration = $this->getConfiguration($configs, $container)) {
            $config = $this->processConfiguration($configuration, $configs);

            $definition = $container->getDefinition('skillbox_symfony.article_content_provider');
            $definition->setArgument(0, $config['is_bold']);

            if (isset($config['article_word_decorator'])) {
                $container->setAlias('skillbox_symfony.word_decorator', $config['article_word_decorator']);
                //$definition->setArgument(1, new Reference($config['article_word_decorator']));
            }
        }
    }

    public function getAlias(): string
    {
        return self::ALIAS;
    }
}
