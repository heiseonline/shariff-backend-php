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
    protected BackendManager $backendManager;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $domains = $config['domains'] ?? [];
        // stay compatible to old configs
        if (isset($config['domain'])) {
            $domains[] = $config['domain'];
        }

        $clientOptions = [];
        if (isset($config['client'])) {
            $clientOptions = $config['client'];
        }
        $client = new Client($clientOptions);
        $baseCacheKey = md5(json_encode($config));

        $cacheClass = $config['cacheClass'] ?? LaminasCache::class;
        $cache = new $cacheClass($config['cache'] ?? []);

        $serviceFactory = new ServiceFactory($client);
        $this->backendManager = new BackendManager(
            $baseCacheKey,
            $cache,
            $client,
            $domains,
            $serviceFactory->getServicesByName($config['services'] ?? [], $config)
        );
    }

    /**
     * @param string $url
     *
     * @return array|mixed|null
     */
    public function get(string $url)
    {
        return $this->backendManager->get($url);
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->backendManager->setLogger($logger);
    }
}
