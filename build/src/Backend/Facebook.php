<?php

namespace Heise\Shariff\Backend;

class Facebook extends Request implements ServiceInterface
{

    public function getName()
    {
        return 'facebook';
    }

    public function getRequest($url)
    {
        $fql = 'https://graph.facebook.com/fql?q=SELECT total_count FROM link_stat WHERE url="'.$url.'"';
        return $this->createRequest($fql);
    }

    public function extractCount($data)
    {
        return (isset($data['data']) && isset($data['data'][0]) && isset($data['data'][0]['total_count']))
            ? $data['data'][0]['total_count'] : 0;
    }
}
