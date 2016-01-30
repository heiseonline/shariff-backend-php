<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Class Request.
 */
abstract class Request
{
    /** @var ClientInterface */
    protected $client;

    /** @var array */
    protected $config;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     * @param string $method
     * @param array  $options
     *
     * @return RequestInterface
     */
    protected function createRequest($url, $method = 'GET', $options = [])
    {
        // $defaults = array('future' => true, 'debug' => true);
        $defaults = ['future' => true, 'timeout' => 5.0];

        return new \GuzzleHttp\Psr7\Request($method, $url, array_merge($defaults, $options));
    }

    /**
     * {@inheritdoc}
     */
    public function filterResponse($content)
    {
        return $content;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }
}
