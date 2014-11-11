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
        $facebookURL = 'https://api.facebook.com/method/fql.query';
        $facebookURL .= '?format=json';
        $facebookURL .= '&query=select like_count from link_stat where url="' . $url . '"';
        return $this->createRequest($facebookURL);
    }

    public function extractCount($data)
    {
        return $data[0]['like_count'];
    }
}
