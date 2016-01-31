<?php

namespace Heise\Shariff\Backend;

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
        $query = 'https://www.xing-share.com/spi/shares/statistics?url=' . urlencode($url);
        return $this->createRequest($query, 'POST');
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        return isset($data['share_counter']) ? $data['share_counter'] : 0;
    }
}
