<?php

namespace Heise\Shariff\Backend;

/**
 * Class Buffer.
 */
class Buffer extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'buffer';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url)
    {
        return new \GuzzleHttp\Psr7\Request(
            'GET',
            'https://api.bufferapp.com/1/links/shares.json?url='.urlencode($url)
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
