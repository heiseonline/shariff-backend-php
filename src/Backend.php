<?php

namespace Heise\Shariff;

use GuzzleHttp\Client;
use Heise\Shariff\Backend\BackendManager;
use Heise\Shariff\Backend\ServiceFactory;
use Psr\Log\LoggerInterface;

/**
 * Class Backend.
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
        $domains = $config['domains'];
        // stay compatible to old configs
        if (isset($config['domain'])) {
            array_push($domains, $config['domain']);
        }

        $clientOptions = [];
        if (isset($config['client'])) {
            $clientOptions = $config['client'];
        }
        $client = new Client($clientOptions);
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
            $domains,
            $serviceFactory->getServicesByName($config['services'], $config)
        );
    }

    /**
     * @param string $url
     *
     * @return array
     */
    public function get($url)
    {
        return $this->backendManager->get($url);
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->backendManager->setLogger($logger);
    }
}
