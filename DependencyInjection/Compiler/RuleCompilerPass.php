<?php

/**
 * Created by PhpStorm.
 * User: chpyr
 * Date: 06/09/15
 * Time: 13:08
 */

namespace DeejayFilesOrganizerBundle\DependencyInjection\Compiler;

use DeejayFilesOrganizerBundle\DeejayFilesOrganizerBundle;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RuleCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $managerService = DeejayFilesOrganizerBundle::BUNDLE_ALIAS.'.rule_manager';
        $tagName = DeejayFilesOrganizerBundle::BUNDLE_ALIAS.'_rule';

        if (!$container->hasDefinition($managerService)) {
            return;
        }

        $providerManager = $container->getDefinition(
            $managerService
        );

        $taggedServices = $container->findTaggedServiceIds(
            $tagName
        );
        foreach ($taggedServices as $id => $attributes) {
            $providerManager->addMethodCall(
                'addRule',
                [
                    new Reference($id)
                ]
            );
        }
    }
}