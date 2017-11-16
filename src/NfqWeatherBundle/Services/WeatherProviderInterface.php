<?php
/**
 * Created by PhpStorm.
 * User: ignas
 * Date: 17.10.12
 * Time: 18.33
 */
namespace NfqWeatherBundle\Services;

interface WeatherProviderInterface{
    /**
     * @throws WeatherProviderException;
     */
    public function fetch(Location $location): Weather;
}