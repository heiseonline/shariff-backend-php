<?php

namespace Heise\Shariff\Backend;

class GooglePlus extends Request implements ServiceInterface
{

    public function getName()
    {
        return 'googleplus';
    }

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

    public function extractCount($data)
    {
        return $data['result']['metadata']['globalCounts']['count'];
    }
}
