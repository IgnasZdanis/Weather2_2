<?php
/**
 * Created by PhpStorm.
 * User: ignas
 * Date: 17.10.18
 * Time: 15.22
 */

declare(strict_types=1);

namespace NfqWeatherBundle\Services;

define('KEY2', '69286ad737e80e38');

class WundergroundWeatherProvider implements WeatherProviderInterface
{
    private $key;
    public function __construct($key)
    {
        $this->key = $key;
    }

    public function fetch(Location $location) : Weather {
        $data = $this->getData($location);
        if (!$this->isDataCorrect($data)) {
            throw new WeatherProviderException("Wrong data");
        }
        return $this->extractData($data);
    }

    public function getData(Location $location) {
        $url='http://api.wunderground.com/api/'.$this->key.
            '/conditions/q/'.$location->getLat().','.$location->getLon().'.json';
        $json=file_get_contents($url);
        return json_decode($json,true);
    }

    private function isDataCorrect($data):bool {
        if($data === null || !isset(
                $data['current_observation']['temp_c'],
                $data['current_observation']['wind_kph'],
                $data['current_observation']['relative_humidity'],
                $data['current_observation']['pressure_mb']
            )) {
            return false;
        }
        return true;
    }

    private function extractData($data):Weather {
        $temperature = $data['current_observation']['temp_c'];
        $windSpeedKpH = $data['current_observation']['wind_kph'];
        $math = new WeatherMath();
        $windSpeedMpS = $math->kphToMps($windSpeedKpH);
        $humidity = (float)rtrim($data['current_observation']['relative_humidity'], "%");
        $pressure = (float)$data['current_observation']['pressure_mb'];
        return new Weather($temperature, $windSpeedMpS, $humidity, $pressure);
    }
}