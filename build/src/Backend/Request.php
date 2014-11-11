<?php
namespace Heise\Shariff\Backend;

abstract class Request
{

    protected $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    protected function createRequest($url, $method = 'GET', $json = null)
    {
        $req = $this->client->createRequest(
            $method,
            $url,
            ['future' => true, 'json' => $json]
        );
        return $req;
    }
}
