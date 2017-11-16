<?php
/**
 * Created by PhpStorm.
 * User: ignas
 * Date: 17.11.16
 * Time: 22.17
 */

namespace NfqWeatherBundle\Services;


class NfqWeather
{
    private $provider;
    public function __construct(WeatherProviderInterface $provider)
    {
        $this->provider = $provider;
    }
    public function fetch(Location $location){
        return $this->provider->fetch($location);
    }
}