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
     * @param array  $options This parameter is ignored and is only present for backwards compatibility reasons.
     *
     * @return RequestInterface
     *
     * @deprecated This method is not used anymore and will be removed with version 6.
     *             Use \GuzzleHttp\Psr7\Request directly instead.
     */
    protected function createRequest($url, $method = 'GET', $options = [])
    {
        trigger_error('This method is not used anymore and will be removed with version 6.'
                    .' Use \GuzzleHttp\Psr7\Request directly instead.', E_USER_DEPRECATED);

        return new \GuzzleHttp\Psr7\Request($method, $url);
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
