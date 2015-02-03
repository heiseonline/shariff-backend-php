<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\Client;

abstract class Request
{
    /** @var Client */
    protected $client;

    /** @var array */
    protected $config;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function createRequest($url, $method = 'GET', $options = array())
    {
        // $defaults = array('future' => true, 'debug' => true);
        $defaults = array('future' => true);

        $req = $this->client->createRequest(
            $method,
            $url,
            array_merge($defaults, $options)
        );

        return $req;
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
    }
}
