<?php

namespace Heise\Shariff\Backend;

/**
 * Class GooglePlus
 *
 * @package Heise\Shariff\Backend
 */
class GooglePlus extends Request implements ServiceInterface
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'googleplus';
    }

    /**
     * @param string $url
     * @return \GuzzleHttp\Message\Request|\GuzzleHttp\Message\RequestInterface
     */
    public function getRequest($url)
    {
        $gPlusUrl = 'https://clients6.google.com/rpc?key=AIzaSyCKSbrvQasunBoV16zDH9R33D88CeLr9gQ';
        $json = array(
            'method' => 'pos.plusones.get',
            'id'     => 'p',
            'params' => array(
                'nolog'   => 'true',
                'id'      => $url,
                'source'  => 'widget',
                'userId'  => '@viewer',
                'groupId' => '@self'
            ),
            'jsonrpc'    => '2.0',
            'key'        => 'p',
            'apiVersion' => 'v1'
        );
        return $this->createRequest($gPlusUrl, 'POST', array('json' => $json));
    }

    /**
     * @param array $data
     * @return int
     */
    public function extractCount(array $data)
    {
        return $data['result']['metadata']['globalCounts']['count'];
    }
}
