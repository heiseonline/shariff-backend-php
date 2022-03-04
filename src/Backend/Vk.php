<?php

namespace Heise\Shariff\Backend;

use Psr\Http\Message\RequestInterface;

/**
 * Class Vk.
 */
class Vk extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'vk';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest(string $url): RequestInterface
    {
        return new \GuzzleHttp\Psr7\Request(
            'GET',
            'https://vk.com/share.php?act=count&index=1&url=' . urlencode($url)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function filterResponse(string $content): string
    {
        // 'VK.Share.count(1, x);' with x being the count
        $strCount = mb_substr($content, 18, mb_strlen($content) - 20);

        return ($strCount ? '{"count": ' . $strCount . '}' : '');
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data): int
    {
        return $data['count'] ?? 0;
    }
}
