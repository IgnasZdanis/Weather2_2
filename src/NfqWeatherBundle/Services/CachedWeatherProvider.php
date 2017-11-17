<?php
/**
 * Created by PhpStorm.
 * User: ignas
 * Date: 17.10.18
 * Time: 17.36
 */

namespace NfqWeatherBundle\Services;

//use Psr\Cache\CacheItemInterface;
//use Symfony\Component\Cache\Simple\FilesystemCache;
//use Nfq\Weather\DelegatingWeatherProvider;

use Psr\Cache\CacheItemPoolInterface;

class CachedWeatherProvider implements WeatherProviderInterface
{
    private $cache;
    private $ttl;
    private $weatherProvider;

    public function __construct(WeatherProviderInterface $weatherProvider, $ttl, CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
        $this->weatherProvider = $weatherProvider;
        $this->ttl = $ttl;
    }

    public function fetch(Location $location): Weather
    {
        $weather = $this->cache->getItem((string)$location);
        if(!$weather->isHit()) {
            $weather->set($this->weatherProvider->fetch($location));
            $weather->expiresAfter($this->ttl);
            $this->cache->save($weather);
        }
        return $weather->get();
    }

    /**
     * @return CacheItemPoolInterface
     */
    public function getCache(): CacheItemPoolInterface
    {
        return $this->cache;
    }

    /**
     * @param CacheItemPoolInterface $cache
     */
    public function setCache(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return WeatherProviderInterface
     */
    public function getWeatherProvider(): WeatherProviderInterface
    {
        return $this->weatherProvider;
    }

    /**
     * @param WeatherProviderInterface $weatherProvider
     */
    public function setWeatherProvider(WeatherProviderInterface $weatherProvider)
    {
        $this->weatherProvider = $weatherProvider;
    }
}