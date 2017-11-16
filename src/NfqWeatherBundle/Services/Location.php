<?php

namespace NfqWeatherBundle\Services;

class Location {
	private $lon, $lat;
	public function __construct(float $lat, float $lon)
	{
		$this->lon = $lon;
		$this->lat = $lat;
	}

	public function __toString() {
        return (string)$this->getLat().",".(string)$this->getLon();
    }

public function getLon(): float
{
return $this->lon;
}
public function getLat(): float
{
return $this->lat;
}
}
