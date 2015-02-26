<?php

namespace Heise\Shariff\Backend;

/**
 * Class StumbleUpon
 *
 * @package Heise\Shariff\Backend
 */
class StumbleUpon extends Request implements ServiceInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'stumbleupon';
    }

    /**
     * @param string $url
     * @return \GuzzleHttp\Message\Request|\GuzzleHttp\Message\RequestInterface
     */
    public function getRequest($url)
    {
        return $this->createRequest('https://www.stumbleupon.com/services/1.01/badge.getinfo?url='.urlencode($url));
    }

    /**
     * @param array $data
     * @return int
     */
    public function extractCount(array $data)
    {
        return (isset($data['result']['views'])) ? $data['result']['views']+0 : 0;
    }
}
