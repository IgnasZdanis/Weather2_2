<?php

namespace NfqWeatherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nfq_weather');
        $rootNode
            ->children()
                ->enumNode('provider')
                    ->values(['openweathermap', 'wunderground', 'delegating', 'cached'])
                ->end()
                ->arrayNode('providers')
                    ->children()
                        ->arrayNode('openweathermap')
                            ->children()
                                ->scalarNode('api_key')->end()
                            ->end()
                        ->end()
                        ->arrayNode('wunderground')
                            ->children()
                                ->scalarNode('api_key')->end()
                            ->end()
                        ->end()
                        ->arrayNode('delegating')
                            ->children()
                                ->arrayNode('providers')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('cached')
                            ->children()
                                ->enumNode('provider')
                                    ->values(['openweathermap', 'wunderground', 'delegating'])
                                ->end()
                                ->integerNode('ttl')
                                    ->min(0)
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
        return $treeBuilder;
    }
}
