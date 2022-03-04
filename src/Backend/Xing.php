<?php

namespace Heise\Shariff\Backend;

use Psr\Http\Message\RequestInterface;

/**
 * Class Xing.
 */
class Xing extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'xing';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest(string $url): RequestInterface
    {
        return new \GuzzleHttp\Psr7\Request(
            'POST',
            'https://www.xing-share.com/spi/shares/statistics?url=' . urlencode($url)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data): int
    {
        return $data['share_counter'] ?? 0;
    }
}
