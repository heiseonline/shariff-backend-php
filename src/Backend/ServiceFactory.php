<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\ClientInterface;

/**
 * Class ServiceFactory
 *
 * @package Heise\Shariff\Backend
 */
class ServiceFactory
{
    /** @var ClientInterface */
    protected $client;

    /** @var ServiceInterface[] */
    protected $serviceMap = array();

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $name
     * @param ServiceInterface $service
     */
    public function registerService($name, ServiceInterface $service)
    {
        $this->serviceMap[$name] = $service;
    }

    /**
     * @param array $serviceNames
     * @param array $config
     * @return array
     */
    public function getServicesByName(array $serviceNames, array $config)
    {
        $services = array();
        foreach ($serviceNames as $serviceName) {
            $services[] = $this->createService($serviceName, $config);
        }
        return $services;
    }

    /**
     * @param string $serviceName
     * @param array $config
     * @return ServiceInterface
     */
    protected function createService($serviceName, array $config)
    {
        if (isset($this->serviceMap[$serviceName])) {
            $service = $this->serviceMap[$serviceName];
        } else {
            $serviceClass = 'Heise\\Shariff\\Backend\\' . $serviceName;
            $service = new $serviceClass($this->client);
        }

        if (isset($config[$serviceName])) {
            $service->setConfig($config[$serviceName]);
        }

        return $service;
    }
}
