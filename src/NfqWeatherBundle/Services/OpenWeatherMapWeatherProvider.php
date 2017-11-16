<?php
/**
 * Created by PhpStorm.
 * User: ignas
 * Date: 17.10.12
 * Time: 18.15
 */
declare(strict_types=1);

namespace NfqWeatherBundle\Services;

//use Nfq\Weather\WeatherMath;
//use Nfq\Weather\WeatherProviderException;

define('KEY', 'f46ee0a183d63a6bd806a57cffcd69bd');

class OpenWeatherMapWeatherProvider implements WeatherProviderInterface
{
    private $key;
    public function __construct($key)
    {
        $this->key = $key;
    }

    public function fetch(Location $location):Weather {
        $data = $this->getData($location);
        if(!$this->isDataCorrect($data)) {
            throw new WeatherProviderException('Wrong data');
        }
        return $this->extractData($data);
    }

    private function getData(Location $location) {
        $url = 'http://api.openweathermap.org/data/2.5/weather?lat='.$location->getLat().'&lon='.$location->getLon().'&appid='.$this->key;
        $json=file_get_contents($url);
        return json_decode($json,true);
    }

    private function isDataCorrect($data):bool {
        if($data === null || !isset(
            $data['main']['temp'],
            $data['main']['humidity'],
            $data['main']['pressure'],
            $data['wind']['speed']
        )) {
            return false;
        }
        return true;
    }

    private function extractData($data) : Weather {
        $temperatureK = $data['main']['temp'];
        $math = new WeatherMath();
        $temperatureC = $math->kelvinToCelsius($temperatureK);
        $windSpeed = $data['wind']['speed'];
        $humidity = $data['main']['humidity'];
        $pressure = $data['main']['pressure'];
        return new Weather($temperatureC, $windSpeed, $humidity, $pressure);
    }
}