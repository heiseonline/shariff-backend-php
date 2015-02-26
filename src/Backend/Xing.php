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
     * @return string
     */
    public function getName()
    {
        return 'xing';
    }

    /**
     * @param string $url
     * @return \GuzzleHttp\Message\Request
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
     * @param array $data
     * @return int
     */
    public function extractCount(array $data)
    {
        return $data['share_counter'];
    }
}
