<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\Client;

class ServiceFactory
{
    /** @var Client */
    protected $client;

    /** @var array */
    protected $serviceMap;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->serviceMap = array();
    }

    public function registerService($name, $service)
    {
        $this->serviceMap[$name] = $service;
    }

    public function getServicesByName($serviceNames, $config)
    {
        $services = array();
        foreach ($serviceNames as $serviceName) {
            $services[] = $this->createService($serviceName, $config);
        }
        return $services;
    }

    protected function createService($serviceName, $config)
    {
        if (isset($this->serviceMap[$serviceName])) {
            $service = $this->serviceMap[$serviceName];
        } else {
            $serviceClass = 'Heise\Shariff\Backend\\'.$serviceName;
            $service = new $serviceClass($this->client);
        }

        if (isset($config[$serviceName])) {
            $service->setConfig($config[$serviceName]);
        }

        return $service;
    }
}
