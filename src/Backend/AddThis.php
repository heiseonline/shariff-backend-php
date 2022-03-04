<?php

namespace Heise\Shariff\Backend;

use Psr\Http\Message\RequestInterface;

/**
 * Class AddThis.
 */
class AddThis extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'addthis';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url): RequestInterface
    {
        return new \GuzzleHttp\Psr7\Request(
            'GET',
            'https://api-public.addthis.com/url/shares.json?url=' . urlencode($url)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data): int
    {
        return $data['shares'] ?? 0;
    }
}
