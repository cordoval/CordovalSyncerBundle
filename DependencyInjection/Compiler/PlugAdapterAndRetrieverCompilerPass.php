<?php

namespace Cordoval\SyncerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class PlugAdapterAndRetrieverCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $manager = $container->getDefinition('cordoval_syncer.manager');

        foreach ($container->findTaggedServiceIds('cordoval.sync_adapter') as $id => $attributes) {
            $manager->addMethodCall('addServiceAdapter', array(new Reference($id)));
        }

        foreach ($container->findTaggedServiceIds('cordoval.entity_retriever') as $id => $attributes) {
            $manager->addMethodCall('addLocalEntityRetriever', array(
                    $attributes[0]['entityName'],
                    new Reference($id),
                    $attributes[0]['findByIdMethod'],
                )
            );
        }
    }
}