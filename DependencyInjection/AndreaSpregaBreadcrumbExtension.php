<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Loads the service definitions.
 */
class AndreaSpregaBreadcrumbExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'asprega_breadcrumb';
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('asprega_breadcrumb.template', $config['template']);
    }
}
