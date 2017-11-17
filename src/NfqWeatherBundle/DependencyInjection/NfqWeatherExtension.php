<?php

namespace NfqWeatherBundle\DependencyInjection;

use NfqWeatherBundle\Services\CachedWeatherProvider;
use NfqWeatherBundle\Services\DelegatingWeatherProvider;
use NfqWeatherBundle\Services\NfqWeather;
use NfqWeatherBundle\Services\OpenWeatherMapWeatherProvider;
use NfqWeatherBundle\Services\WundergroundWeatherProvider;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class NfqWeatherExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container
            ->register('cache', FilesystemAdapter::class);
        $container
            ->register('openweathermap', OpenWeatherMapWeatherProvider::class)
            ->addArgument($config['providers']['openweathermap']['api_key']);
        $container
            ->register('wunderground', WundergroundWeatherProvider::class)
            ->addArgument($config['providers']['wunderground']['api_key']);
        $delegatingProviders = $config['providers']['delegating']['providers'];
        $delegatingProviderArray = [];
        if(in_array('openweathermap', $delegatingProviders)) {
            array_push($delegatingProviderArray, new Reference('openweathermap'));
        }
        if(in_array('wunderground', $delegatingProviders)) {
            array_push($delegatingProviderArray, new Reference('wunderground'));
        }
        $container
            ->register('delegating', DelegatingWeatherProvider::class)
            ->addArgument($delegatingProviderArray);
        $container
            ->register('cached', CachedWeatherProvider::class)
            ->addArgument(new Reference($config['providers']['cached']['provider']))
            ->addArgument($config['providers']['cached']['ttl'])
            ->addArgument(new Reference('cache'));
        $container
            ->register('nfq_weather', NfqWeather::class)
            ->addArgument(new Reference($config['provider']));
    }
}
