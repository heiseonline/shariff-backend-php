<?php

namespace Heise\Shariff\Backend;

/**
 * Class LinkedIn
 *
 * @package Heise\Shariff\Backend
 */
class LinkedIn extends Request implements ServiceInterface
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'linkedin';
    }

    /**
     * @param string $url
     * @return \GuzzleHttp\Message\Request|\GuzzleHttp\Message\RequestInterface
     */
    public function getRequest($url)
    {
        $url = 'https://www.linkedin.com/countserv/count/share?url='.urlencode($url).'&lang=de_DE&format=json';
        return $this->createRequest($url);
    }

    /**
     * @param array $data
     * @return int
     */
    public function extractCount(array $data)
    {
        return $data['count'];
    }
}
