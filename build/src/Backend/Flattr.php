<?php

namespace Heise\Shariff\Backend;

/**
 * Class Flattr
 *
 * @package Heise\Shariff\Backend
 */
class Flattr extends Request implements ServiceInterface
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'flattr';
    }

    /**
     * @param string $url
     * @return \GuzzleHttp\Message\Request|\GuzzleHttp\Message\RequestInterface
     */
    public function getRequest($url)
    {
        $url = 'https://api.flattr.com/rest/v2/things/lookup/?url='.urlencode($url);
        return $this->createRequest($url);
    }

    /**
     * @param array $data
     * @return int
     */
    public function extractCount(array $data)
    {
        return (isset($data['flattrs'])) ? $data['flattrs'] : 0;
    }
}
