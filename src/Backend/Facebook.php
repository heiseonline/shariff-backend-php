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
        return $this->createRequest('https://graph.facebook.com/?id='.$url);
    }

    public function extractCount($data)
    {
        return (isset($data['shares'])) ? $data['shares'] : 0;
    }
}

