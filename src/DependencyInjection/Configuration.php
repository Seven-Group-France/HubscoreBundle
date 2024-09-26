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
            ->scalarNode('api_url')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('api_version')->defaultValue('v1')->cannotBeEmpty()->end()
            ->arrayNode('endpoints')
              ->children()
                ->scalarNode('login')->defaultValue('/login_check')->cannotBeEmpty()->end()
                ->arrayNode('mail')
                  ->children()
                    ->scalarNode('list')->defaultValue('/mails')->cannotBeEmpty()->end()
                    ->scalarNode('post')->defaultValue('/mails')->cannotBeEmpty()->end()
                    ->scalarNode('get')->defaultValue('/mails/{id}')->cannotBeEmpty()->end()
                  ->end()
                ->end()
                ->arrayNode('campaign')
                  ->children()
                    ->scalarNode('list')->defaultValue('/mailsends')->cannotBeEmpty()->end()
                    ->scalarNode('post')->defaultValue('/mailsends')->cannotBeEmpty()->end()
                    ->scalarNode('get')->defaultValue('/mailsends/{id}')->cannotBeEmpty()->end()
                    ->scalarNode('put')->defaultValue('/mailsends/{id}')->cannotBeEmpty()->end()
                    ->scalarNode('delete')->defaultValue('/mailsends/{id}')->cannotBeEmpty()->end()
                    ->scalarNode('send')->defaultValue('/sends/mails')->cannotBeEmpty()->end()
                  ->end()
                ->end()
                ->arrayNode('database')
                  ->children()
                    ->scalarNode('list')->defaultValue('/databases')->cannotBeEmpty()->end()
                    ->scalarNode('post')->defaultValue('/databases')->cannotBeEmpty()->end()
                    ->scalarNode('get')->defaultValue('/databases/{id}')->cannotBeEmpty()->end()
                    ->scalarNode('put')->defaultValue('/databases/{id}')->cannotBeEmpty()->end()
                    ->scalarNode('delete')->defaultValue('/databases/{id}')->cannotBeEmpty()->end()
                  ->end() 
                ->end()
                ->arrayNode('records')
                  ->children()
                    ->scalarNode('list')->defaultValue('/databases/{id}/records')->cannotBeEmpty()->end()
                    ->scalarNode('post')->defaultValue('/databases/{id}/records')->cannotBeEmpty()->end()
                    ->scalarNode('get')->defaultValue('/databases/{id}/records/{recordId}')->cannotBeEmpty()->end()
                    ->scalarNode('put')->defaultValue('/databases/{id}/records/{recordId}')->cannotBeEmpty()->end()
                    ->scalarNode('delete')->defaultValue('/databases/{id}/records/{recordId}')->cannotBeEmpty()->end()
                  ->end() 
                ->end()
              ->end()
        ;

        return $treeBuilder;
    }
}