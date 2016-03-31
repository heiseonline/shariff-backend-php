<?php

namespace Heise\Shariff\Backend;

/**
 * Class LinkedIn.
 */
class LinkedIn extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'linkedin';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url)
    {
        return new \GuzzleHttp\Psr7\Request(
            'GET',
            'https://www.linkedin.com/countserv/count/share?url='.urlencode($url).'&lang=de_DE&format=json'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        return isset($data['count']) ? $data['count'] : 0;
    }
}
