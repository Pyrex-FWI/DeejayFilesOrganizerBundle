<?php

namespace DeejayFilesOrganizerBundle\DependencyInjection;

use DeejayFilesOrganizerBundle\DeejayFilesOrganizerBundle;
use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\ScalarNode;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {

        $treeBuilder = new TreeBuilder();
        $digital_dj_poolRoot = $treeBuilder->root('deejay_file_organizer');



        return $treeBuilder;
    }
}
