<?php

namespace Heise\Shariff\Backend;

use Psr\Http\Message\RequestInterface;

/**
 * Interface ServiceInterface.
 */
interface ServiceInterface
{
    /**
     * @param string $url
     *
     * @return RequestInterface
     */
    public function getRequest($url): RequestInterface;

    /**
     * @param array $data
     *
     * @return int
     *
     * Unfortunately using int as return type here force us to cast returned value to int in every implementation, so
     * currently phpdoc is enough
     */
    public function extractCount(array $data);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $content
     *
     * @return string
     */
    public function filterResponse(string $content): string;

    /**
     * @param array $config
     */
    public function setConfig(array $config);
}
