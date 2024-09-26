<?php

namespace Sevengroup\HubscoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sevengroup_hubscore');

        $treeBuilder->getRootNode()
          ->children()
            ->scalarNode('api_url')
              ->isRequired()
              ->cannotBeEmpty()
            ->end()
        ;

        return $treeBuilder;
    }
}