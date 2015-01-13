<?php

namespace Heise\Shariff\Backend;

class StumbleUpon extends Request implements ServiceInterface
{

    public function getName()
    {
        return 'stumbleupon';
    }

    public function getRequest($url)
    {
        return $this->createRequest('https://www.stumbleupon.com/services/1.01/badge.getinfo?url='.urlencode($url));
    }

    public function extractCount($data)
    {
        return (isset($data['result']['views'])) ? $data['result']['views']+0 : 0;
    }
}
