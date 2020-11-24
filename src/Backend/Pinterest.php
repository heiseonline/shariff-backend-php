<?php

namespace Heise\Shariff\Backend;

use Psr\Http\Message\RequestInterface;

/**
 * Class Pinterest.
 */
class Pinterest extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'pinterest';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url): RequestInterface
    {
        return new \GuzzleHttp\Psr7\Request(
            'GET',
            'https://api.pinterest.com/v1/urls/count.json?callback=x&url='.urlencode($url)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function filterResponse(string $content): string
    {
        return mb_substr($content, 2, -1);
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        return $data['count'] ?? 0;
    }
}
