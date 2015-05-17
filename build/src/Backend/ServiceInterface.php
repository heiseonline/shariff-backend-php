<?php

namespace Heise\Shariff\Backend;

/**
 * Interface ServiceInterface
 *
 * @package Heise\Shariff\Backend
 */
interface ServiceInterface
{
    /**
     * @param string $url
     * @return \GuzzleHttp\Message\Request
     */
    public function getRequest($url);

    /**
     * @param array $data
     * @return int
     */
    public function extractCount(array $data);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param array $config
     * @return void
     */
    public function setConfig(array $config);
}
