<?php

namespace Heise\Shariff\Backend;

use Psr\Http\Message\RequestInterface;

/**
 * Class Buffer.
 */
class Buffer extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'buffer';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url): RequestInterface
    {
        return new \GuzzleHttp\Psr7\Request(
            'GET',
            'https://api.bufferapp.com/1/links/shares.json?url=' . urlencode($url)
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
