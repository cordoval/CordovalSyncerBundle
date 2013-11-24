<?php

namespace Cordoval\SyncerBundle;

use Cordoval\SyncerBundle\DependencyInjection\Compiler\PlugAdapterAndRetrieverCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CordovalSyncerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new PlugAdapterAndRetrieverCompilerPass());
    }
}
