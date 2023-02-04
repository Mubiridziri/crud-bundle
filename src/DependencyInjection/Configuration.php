<?php

namespace Mubiridziri\Crud\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('crud');
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('crud');
        }

        /**
         *
         * @Example
         * crud:
         *   pagination:
         *      default_limit: 10
         *   sorting:
         *      default_field: 'id'
         *      default_destination: 'desc'
         */
        $rootNode->children()
            ->arrayNode('pagination')
            ->children()
            ->scalarNode('default_limit')
            ->defaultValue(10)
            ->end()
            ->end()
            ->arrayNode('sorting')
            ->children()
            ->scalarNode('default_field')
            ->defaultValue('id')
            ->end()
            ->scalarNode('default_destination')
            ->defaultValue('desc')
            ->end()
            ->end();
        return $treeBuilder;
    }
}