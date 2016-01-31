<?php

namespace Heise\Shariff\Backend;

/**
 * Class Flattr
 *
 * @package Heise\Shariff\Backend
 */
class Flattr extends Request implements ServiceInterface
{

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'flattr';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url)
    {
        $url = 'https://api.flattr.com/rest/v2/things/lookup/?url='.urlencode($url);
        return $this->createRequest($url);
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        return (isset($data['flattrs'])) ? $data['flattrs'] : 0;
    }
}
