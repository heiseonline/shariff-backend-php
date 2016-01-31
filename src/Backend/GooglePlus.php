<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\Psr7;

/**
 * Class GooglePlus
 *
 * @package Heise\Shariff\Backend
 */
class GooglePlus extends Request implements ServiceInterface
{

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'googleplus';
    }

    /**
     * {@inheritdoc}
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

        $body = Psr7\stream_for(json_encode($json));
        return $this->createRequest($gPlusUrl, 'POST', array('body' => $body));
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        if (!empty($data['result']['metadata']['globalCounts']['count'])) {
            return $data['result']['metadata']['globalCounts']['count'];
        }
        return 0;
    }
}
