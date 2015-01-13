<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\Client;

abstract class Request
{

    protected $client;

    public function __construct()
    {
        $this->client = new Client();
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
}
