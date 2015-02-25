<?php

namespace Heise\Shariff\Backend;

/**
 * Class Reddit
 *
 * @package Heise\Shariff\Backend
 */
class Reddit extends Request implements ServiceInterface
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'reddit';
    }

    /**
     * @param string $url
     * @return \GuzzleHttp\Message\Request|\GuzzleHttp\Message\RequestInterface
     */
    public function getRequest($url)
    {
        return $this->createRequest('https://www.reddit.com/api/info.json?url='.urlencode($url));
    }

    /**
     * @param array $data
     * @return int
     */
    public function extractCount(array $data)
    {
        $count = 0;
        foreach ($data['data']['children'] as $child) {
            $count += $child['data']['score'];
        }
        return $count;
    }
}
