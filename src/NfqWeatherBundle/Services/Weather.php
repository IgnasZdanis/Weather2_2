<?php
/**
 * Created by PhpStorm.
 * User: ignas
 * Date: 17.10.12
 * Time: 18.13
 */

namespace NfqWeatherBundle\Services;



class Weather
{
    private $temperature;
    private $windSpeed;
    private $humidity;
    private $pressure;

    public function __construct(float $temperature, float $windSpeed, float $humidity, float $pressure)
    {
        $this->temperature = $temperature;
        $this->windSpeed = $windSpeed;
        $this->humidity = $humidity;
        $this->pressure = $pressure;
    }


    public function getTemperature():float
    {
        return $this->temperature;
    }


    public function setTemperature(float $temperature)
    {
        $this->temperature = $temperature;
    }

    public function getWindSpeed():float
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(float $windSpeed)
    {
        $this->windSpeed = $windSpeed;
    }

    public function getHumidity():float
    {
        return $this->humidity;
    }

    public function setHumidity(float $humidity)
    {
        $this->humidity = $humidity;
    }

    public function getPressure():float
    {
        return $this->pressure;
    }

    public function setPressure(float $pressure)
    {
        $this->pressure = $pressure;
    }
}