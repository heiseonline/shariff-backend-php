<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Pool;
use Heise\Shariff\CacheInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BackendManager
 *
 * @package Heise\Shariff\Backend
 */
class BackendManager
{
    /** @var string */
    protected $baseCacheKey;

    /** @var CacheInterface */
    protected $cache;

    /** @var ClientInterface */
    protected $client;

    /** @var string */
    protected $domain;

    /** @var ServiceInterface[] */
    protected $services;

    /**
     * @param string $baseCacheKey
     * @param CacheInterface $cache
     * @param ClientInterface $client
     * @param string $domain
     * @param ServiceInterface[] $services
     */
    public function __construct($baseCacheKey, CacheInterface $cache, ClientInterface $client, $domain, array $services)
    {
        $this->baseCacheKey = $baseCacheKey;
        $this->cache = $cache;
        $this->client = $client;
        $this->domain = $domain;
        $this->services = $services;
    }

    /**
     * @param string $url
     * @return bool
     */
    private function isValidDomain($url)
    {
        if ($this->domain) {
            $parsed = parse_url($url);
            if ($parsed["host"] != $this->domain) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param string $url
     * @return array|mixed|null
     */
    public function get($url)
    {

        // Aenderungen an der Konfiguration invalidieren den Cache
        $cache_key = md5($url.$this->baseCacheKey);

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        if ($this->cache->hasItem($cache_key)) {
            return json_decode($this->cache->getItem($cache_key), true);
        }

        if (!$this->isValidDomain($url)) {
            return null;
        }

        $requests = array_map(
            function ($service) use ($url) {
                /** @var ServiceInterface $service */
                return $service->getRequest($url);
            },
            $this->services
        );

        /** @var ResponseInterface[] $results */
        $results = Pool::batch($this->client, $requests);

        $counts = array();
        $i = 0;
        foreach ($this->services as $service) {
            try {
                $content = $service->filterResponse($results[$i]->getBody()->getContents());
                $counts[$service->getName()] = (int) $service->extractCount(json_decode($content, true));
            } catch (\Exception $e) {
                // Skip service if broken
            }
            $i++;
        }

        $this->cache->setItem($cache_key, json_encode($counts));

        return $counts;
    }
}
