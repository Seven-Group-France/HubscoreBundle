<?php

namespace Sevengroup\HubscoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class SevengroupSecurityExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $container->setParameter('sevengroup_hubscore.api_url', $config['api_url']);
        $container->setParameter('sevengroup_hubscore.api_version', $config['api_version']);
        $container->setParameter('sevengroup_hubscore.endpoints', $config['endpoints']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }
}