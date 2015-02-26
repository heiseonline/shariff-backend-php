<?php

namespace Heise\Shariff\Backend;

/**
 * Class Twitter
 *
 * @package Heise\Shariff\Backend
 */
class Twitter extends Request implements ServiceInterface
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'twitter';
    }

    /**
     * @param string $url
     * @return \GuzzleHttp\Message\Request|\GuzzleHttp\Message\RequestInterface
     */
    public function getRequest($url)
    {
        return $this->createRequest('https://cdn.api.twitter.com/1/urls/count.json?url='.urlencode($url));
    }

    /**
     * @param array $data
     * @return int
     */
    public function extractCount(array $data)
    {
        return $data['count'];
    }
}
