<?php

namespace Heise\Shariff\Backend;

/**
 * Class Pinterest.
 */
class Pinterest extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pinterest';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url)
    {
        return new \GuzzleHttp\Psr7\Request(
            'GET',
            'http://api.pinterest.com/v1/urls/count.json?callback=x&url='.urlencode($url)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function filterResponse($content)
    {
        return mb_substr($content, 2, mb_strlen($content) - 3);
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        return isset($data['count']) ? $data['count'] : 0;
    }
}
