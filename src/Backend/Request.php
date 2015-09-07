<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\Client;

/**
 * Class Request
 *
 * @package Heise\Shariff\Backend
 */
abstract class Request
{
    /** @var Client */
    protected $client;

    /** @var array */
    protected $config;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $options
     * @return \GuzzleHttp\Message\Request
     */
    protected function createRequest($url, $method = 'GET', $options = array())
    {
        // $defaults = array('future' => true, 'debug' => true);
        $defaults = array('future' => true, 'timeout' => 5.0);

        $req = $this->client->createRequest(
            $method,
            $url,
            array_merge($defaults, $options)
        );

        return $req;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }
}
