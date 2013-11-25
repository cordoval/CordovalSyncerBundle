<?php

namespace Cordoval\SyncerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cordoval_syncer');

        $rootNode
            ->children()
                ->arrayNode('adapter')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('entities')
                            ->prototype('scalar')
                            ->end()
                        ->end()
                        ->arrayNode('config')
                            ->treatNullLike(array())
                            ->prototype('scalar')
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('manager')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('direction')
                            ->defaultValue('download')
                            ->validate()
                            ->ifNotInArray(array('download', 'upload'))
                                ->thenInvalid('Invalid direction "%s"')
                            ->end()
                        ->end()
                        ->booleanNode('delay_dependency_processing')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('use_id_mapping')
                            ->defaultTrue()
                        ->end()
                        ->arrayNode('entities')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('strategy')
                                        ->cannotBeEmpty()
                                        ->isRequired()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('remotes')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('adapter')
                                        ->cannotBeEmpty()
                                        ->isRequired()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
