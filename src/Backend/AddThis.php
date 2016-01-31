<?php

namespace Heise\Shariff\Backend;

/**
 * Class AddThis
 *
 * @package Heise\Shariff\Backend
 */
class AddThis extends Request implements ServiceInterface
{

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'addthis';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url)
    {
        $url = 'http://api-public.addthis.com/url/shares.json?url='.urlencode($url);
        return $this->createRequest($url);
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        return isset($data['shares']) ? $data['shares'] : 0;
    }
}
