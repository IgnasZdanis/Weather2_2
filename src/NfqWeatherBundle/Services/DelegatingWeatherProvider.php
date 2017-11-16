<?php

/**
 * Created by PhpStorm.
 * User: ignas
 * Date: 17.10.12
 * Time: 18.40
 */

namespace NfqWeatherBundle\Services;

//use Nfq\Weather\WeatherProviderInterface;

class DelegatingWeatherProvider implements WeatherProviderInterface
{
    /**
     * @param WeatherProviderInterface[] $providers
     */
    private $providers;

    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    public function fetch(Location $location):Weather {
        foreach ($this->providers as $provider){
            try {
                return $provider->fetch($location);
            } catch (WeatherProviderException $e) {
            }
        }
        throw new WeatherProviderException('No suitable providers found');
    }

    public function getProviders()
    {
        return $this->providers;
    }

    public function setProviders($providers)
    {
        $this->providers = $providers;
    }

}