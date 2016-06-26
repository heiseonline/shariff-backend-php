<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\ClientInterface;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;

/**
 * Class ServiceFactory.
 */
class ServiceFactory
{
    /**
     * @var ClientInterface|HttpClient
     */
    protected $client;

    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /** @var ServiceInterface[] */
    protected $serviceMap = [];

    /**
     * @param ClientInterface|HttpClient $client
     * @param MessageFactory             $messageFactory
     */
    public function __construct($client, MessageFactory $messageFactory = null)
    {
        $this->client         = $client;
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param string           $name
     * @param ServiceInterface $service
     */
    public function registerService($name, ServiceInterface $service)
    {
        $this->serviceMap[$name] = $service;
    }

    /**
     * @param array $serviceNames
     * @param array $config
     *
     * @return array
     */
    public function getServicesByName(array $serviceNames, array $config)
    {
        $services = [];
        foreach ($serviceNames as $serviceName) {
            $services[] = $this->createService($serviceName, $config);
        }

        return $services;
    }

    /**
     * @param string $serviceName
     * @param array  $config
     *
     * @return ServiceInterface
     */
    protected function createService($serviceName, array $config)
    {
        if (isset($this->serviceMap[$serviceName])) {
            $service = $this->serviceMap[$serviceName];
        } else {
            $serviceClass = 'Heise\\Shariff\\Backend\\'.$serviceName;
            $service = new $serviceClass($this->client, $this->messageFactory);
        }

        if (isset($config[$serviceName])) {
            $service->setConfig($config[$serviceName]);
        }

        return $service;
    }
}
