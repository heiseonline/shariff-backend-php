<?php

namespace Heise\Shariff;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Zend\Cache\Storage\Adapter\Filesystem;

class Backend
{

    protected $baseCacheKey;
    protected $cache;
    protected $client;
    protected $domain;
    protected $services;

    public function __construct($config)
    {
        $this->domain = $config["domain"];
        $this->client = new Client();
        $this->baseCacheKey = md5(json_encode($config));

        $this->cache = new Filesystem();
        $options = $this->cache->getOptions();
        $options->setCacheDir(
            array_key_exists("cacheDir", $config["cache"])
            ? $config["cache"]["cacheDir"]
            : sys_get_temp_dir()
        );
        $options->setNamespace('Shariff');
        $options->setTtl($config["cache"]["ttl"]);

        if (function_exists('register_postsend_function')) {
            // for hhvm installations: executing after response / session close
            register_postsend_function(function() {
                $this->cache->clearExpired();
            });
        } else {
            // default
            $this->cache->clearExpired();
        }

        $this->services = $this->getServicesByName($config["services"]);
    }

    private function getServicesByName($serviceNames)
    {
        $services = array();
        foreach ($serviceNames as $serviceName) {
            $serviceName = 'Heise\Shariff\Backend\\'.$serviceName;
            $services[] = new $serviceName();
        }
        return $services;
    }

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
                return $service->getRequest($url);
            },
            $this->services
        );

        $results = Pool::batch($this->client, $requests);

        $counts = array();
        $i = 0;
        foreach ($this->services as $service) {
            if (method_exists($results[$i], "json")) {
                try {
                    $counts[ $service->getName() ] = intval($service->extractCount($results[$i]->json()));
                } catch (\Exception $e) {
                    // Skip service if broken
                }
            }
            $i++;
        }

        $this->cache->setItem($cache_key, json_encode($counts));

        return $counts;
    }
}
