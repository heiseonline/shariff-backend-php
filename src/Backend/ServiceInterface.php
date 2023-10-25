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
    public function getRequest(string $url): RequestInterface;

    /**
     * @param array $data
     *
     * @return int
     */
    public function extractCount(array $data): int;

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
    public function setConfig(array $config): void;
}
