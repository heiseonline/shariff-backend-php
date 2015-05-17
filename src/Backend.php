<?php

namespace Heise\Shariff;

use GuzzleHttp\Client;
use Heise\Shariff\Backend\BackendManager;
use Heise\Shariff\Backend\ServiceFactory;

/**
 * Class Backend
 *
 * @package Heise\Shariff
 */
class Backend
{
    /** @var BackendManager */
    protected $backendManager;

    /**
     * @param array $config
     */
    public function __construct($config)
    {
        $domain = $config['domain'];
        $clientOptions = [];
        if (isset($config['client'])) {
            $clientOptions = $config['client'];
        }
        $client = new Client(['defaults' => $clientOptions]);
        $baseCacheKey = md5(json_encode($config));

        if (isset($config['cacheClass'])) {
            $cacheClass = $config['cacheClass'];
        } else {
            $cacheClass = 'Heise\\Shariff\\ZendCache';
        }
        $cache = new $cacheClass($config['cache']);

        $serviceFactory = new ServiceFactory($client);
        $this->backendManager = new BackendManager(
            $baseCacheKey,
            $cache,
            $client,
            $domain,
            $serviceFactory->getServicesByName($config['services'], $config)
        );
    }

    /**
     * @param string $url
     * @return array
     */
    public function get($url)
    {
        return $this->backendManager->get($url);
    }
}
