<?php

namespace Heise\Shariff\Backend;

/**
 * Class AddThis.
 */
class AddThis extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'addthis';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url)
    {
        return new \GuzzleHttp\Psr7\Request(
            'GET',
            'http://api-public.addthis.com/url/shares.json?url='.urlencode($url)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        return isset($data['shares']) ? $data['shares'] : 0;
    }
}
