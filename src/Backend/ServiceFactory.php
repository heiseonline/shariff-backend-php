<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\ClientInterface;

/**
 * Class ServiceFactory.
 */
class ServiceFactory
{
    /** @var ClientInterface */
    protected $client;

    /** @var ServiceInterface[] */
    protected $serviceMap = [];

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
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
            try {
                $service = $this->createService($serviceName, $config);
            } catch (\InvalidArgumentException $e) {
                continue;
            }
            $services[] = $service;
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
            $service = new $serviceClass($this->client);
        }

        if (isset($config[$serviceName])) {
            $service->setConfig($config[$serviceName]);
        }

        return $service;
    }
}
