<?php

namespace Heise\Shariff\Backend;

/**
 * Class Flattr.
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
        return new \GuzzleHttp\Psr7\Request(
            'GET',
            'https://api.flattr.com/rest/v2/things/lookup/?url='.urlencode($url)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        return (isset($data['flattrs'])) ? $data['flattrs'] : 0;
    }
}
