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
        if (!empty($data['data']['children'])) {
            foreach ($data['data']['children'] as $child) {
                if (!empty($child['data']['score'])) {
                    $count += $child['data']['score'];
                }
            }
        }
        return $count;
    }
}
