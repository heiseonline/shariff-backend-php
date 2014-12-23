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
        $facebookURL = 'https://graph.facebook.com/?id=' . $url . '"';
        return $this->createRequest($facebookURL);
    }

    public function extractCount($data)
    {
        if( isset($data['shares']) )
        {
            return $data['shares'];
        }
        else
        {
            return 0;
        }
    }
}
