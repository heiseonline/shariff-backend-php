<?php
namespace Heise\Shariff\Backend;

abstract class Request
{

    protected $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    protected function createRequest($url, $method = 'GET', $options = [])
    {
        // $defaults = ['future' => true, 'debug' => true];
        $defaults = ['future' => true];

        $req = $this->client->createRequest(
            $method,
            $url,
            array_merge($defaults, $options)
        );

        return $req;
    }
}
