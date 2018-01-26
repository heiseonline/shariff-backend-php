<?php

namespace Heise\Shariff\Backend;

/**
 * Class Vk.
 */
class Vk extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'vk';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url)
    {
        return new \GuzzleHttp\Psr7\Request(
            'GET',
            'https://vk.com/share.php?act=count&index=1&url='.urlencode($url)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function filterResponse($content)
    {
        // 'VK.Share.count(1, x);' with x being the count
        $strCount = mb_substr($content, 18, mb_strlen($content) - 20);
        return ($strCount ? '{"count": ' . $strCount . '}': '');
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        return isset($data['count']) ? $data['count'] : 0;
    }
}
