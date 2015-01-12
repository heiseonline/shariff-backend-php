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
