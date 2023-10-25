<?php

namespace Heise\Shariff\Backend;

use Psr\Http\Message\RequestInterface;

/**
 * Class Reddit.
 */
class Reddit extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'reddit';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest(string $url): RequestInterface
    {
        return new \GuzzleHttp\Psr7\Request('GET', 'https://www.reddit.com/api/info.json?url=' . urlencode($url));
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data): int
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
