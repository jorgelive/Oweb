<?php

namespace Gopro\FullcalendarBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('gopro_fullcalendar');
        $rootNode
            ->children()
            ->arrayNode('calendars')
            ->prototype('array')
                ->children()
                ->scalarNode('entity')->end()
                ->scalarNode('repositorymethod')->end()
                ->arrayNode('parameters')
                    ->children()
                    ->scalarNode('title')->end()
                    ->scalarNode('start')->end()
                    ->scalarNode('end')->end()
                    ->scalarNode('color')->end()
                    ->scalarNode('url')->end()
                    ->end()
                ->end()
            ->end()
         ->end()
        ;

        return $treeBuilder;
    }
}