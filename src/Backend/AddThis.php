<?php

namespace Heise\Shariff\Backend;

/**
 * Class AddThis
 *
 * @package Heise\Shariff\Backend
 */
class AddThis extends Request implements ServiceInterface
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'addthis';
    }

    /**
     * @param string $url
     * @return \GuzzleHttp\Message\Request|\GuzzleHttp\Message\RequestInterface
     */
    public function getRequest($url)
    {
        $url = 'http://api-public.addthis.com/url/shares.json?url='.urlencode($url);
        return $this->createRequest($url);
    }

    /**
     * @param array $data
     * @return int
     */
    public function extractCount(array $data)
    {
        return $data['shares'];
    }
}
