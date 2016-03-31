<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\ClientInterface;

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
