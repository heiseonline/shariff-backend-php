<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\ClientInterface;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Psr\Http\Message\RequestInterface;

/**
 * Class Request.
 */
abstract class Request
{
    /**
     * @var ClientInterface|HttpClient
     */
    protected $client;

    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /** @var array */
    protected $config;

    /**
     * @param ClientInterface|HttpClient $client
     * @param MessageFactory             $messageFactory
     */
    public function __construct($client, MessageFactory $messageFactory = null)
    {
        $this->client         = $client;
        $this->messageFactory = $messageFactory;
    }

    /**
     * Calls the http client.
     *
     * @param string $url
     * @param string $method
     * @param array  $options This parameter is ignored and is only present for backwards compatibility reasons
     *
     * @return RequestInterface
     */
    protected function createRequest($url, $method = 'GET', $options = [])
    {
        // HTTPlug implementation
        if ($this->client instanceof HttpClient) {
            return $this->messageFactory->createRequest($method, $url, $options);
        } else {
            return new \GuzzleHttp\Psr7\Request($method, $url);
        }
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
