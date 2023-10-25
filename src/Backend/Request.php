<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Class Request.
 */
abstract class Request
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $content
     * @return string
     */
    public function filterResponse(string $content): string
    {
        return $content;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    /**
     * @param string $url
     * @param string $method
     *
     * @return RequestInterface
     *
     * @deprecated This method is not used anymore and will be removed with version 6.
     *             Use \GuzzleHttp\Psr7\Request directly instead
     */
    protected function createRequest(string $url, string $method = 'GET'): RequestInterface
    {
        trigger_error('This method is not used anymore and will be removed with version 6.'
            . ' Use \GuzzleHttp\Psr7\Request directly instead.', E_USER_DEPRECATED);

        return new \GuzzleHttp\Psr7\Request($method, $url);
    }
}
