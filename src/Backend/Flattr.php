<?php

namespace Heise\Shariff\Backend;

use Psr\Http\Message\RequestInterface;

/**
 * Class Flattr.
 */
class Flattr extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'flattr';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url): RequestInterface
    {
        return new \GuzzleHttp\Psr7\Request(
            'GET',
            'https://api.flattr.com/rest/v2/things/lookup/?url='.urlencode($url)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        return $data['flattrs'] ?? 0;
    }
}
