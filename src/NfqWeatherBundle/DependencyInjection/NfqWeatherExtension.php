<?php

namespace NfqWeatherBundle\DependencyInjection;

use NfqWeatherBundle\Services\NfqWeather;
use NfqWeatherBundle\Services\OpenWeatherMapWeatherProvider;
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
        $container
            ->register('openweather', OpenWeatherMapWeatherProvider::class)
            ->addArgument('f46ee0a183d63a6bd806a57cffcd69bd');
        $container
            ->register('wunderground', OpenWeatherMapWeatherProvider::class)
            ->addArgument('69286ad737e80e38');
        $container
            ->register('nfq_weather', NfqWeather::class)
            ->addArgument(new Reference('openweather'));
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $def = $container->getDefinition('nfq_weather');
        if ($config['provider'] === 'openweathermap') {
            $def->replaceArgument(0, new Reference('openweather'));
        }
        if ($config['provider'] === 'wundergroung') {
            $def->replaceArgument(0, new Reference('wunderground'));
        }
    }
}
