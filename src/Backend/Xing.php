<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\Post\PostBodyInterface;

/**
 * Class Xing
 *
 * @package Heise\Shariff\Backend
 */
class Xing extends Request implements ServiceInterface
{

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'xing';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url)
    {
        $request = $this->createRequest('https://www.xing-share.com/spi/shares/statistics', 'POST');
        $stream = $request->getBody();
        if ($stream instanceof PostBodyInterface) {
            $stream->setField('url', $url);
        }
        return $request;
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        return isset($data['share_counter']) ? $data['share_counter'] : 0;
    }
}
