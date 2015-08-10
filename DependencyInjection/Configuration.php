<?php

namespace AndreaSprega\Bundle\BreadcrumbBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $builder->root('asprega_breadcrumb')
            ->children()
                ->scalarNode('template')->defaultValue('AndreaSpregaBreadcrumbBundle::breadcrumb.html.twig')->end()
            ->end();
        return $builder;
    }
}
