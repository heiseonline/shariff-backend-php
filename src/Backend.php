<?php

namespace Heise\Shariff;

use Heise\Shariff\Backend\BackendManager;
use Heise\Shariff\Backend\ServiceFactory;
use Http\Adapter\Guzzle6\Client;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Backend.
 */
class Backend
{
    /** @var BackendManager */
    protected $backendManager;

    /**
     * @param array                        $config
     * @param ClientInterface              $client
     * @param RequestFactoryInterface|null $requestFactory
     */
    public function __construct($config, ClientInterface $client = null, RequestFactoryInterface $requestFactory = null)
    {
        $domains = $config['domains'];
        // stay compatible to old configs
        if (isset($config['domain'])) {
            array_push($domains, $config['domain']);
        }

        if ($client === null) {
            $client =  $this->createClientFromConfig($config);
        }

        if ($requestFactory === null) {
            $requestFactory = new Psr17Factory();
        }

        $baseCacheKey = md5(json_encode($config));

        if (isset($config['cacheClass'])) {
            $cacheClass = $config['cacheClass'];
        } else {
            $cacheClass = 'Heise\\Shariff\\ZendCache';
        }
        $cache = new $cacheClass($config['cache']);

        $serviceFactory = new ServiceFactory($client, $requestFactory);
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

    /**
     * @param array $config
     *
     * @return ClientInterface
     */
    private function createClientFromConfig(array $config): ClientInterface
    {
        return Client::createWithConfig($config['client'] ?? []);
    }
}
