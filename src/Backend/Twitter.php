<?php

namespace Heise\Shariff\Backend;

class Twitter extends Request implements ServiceInterface
{

    public function getName()
    {
        return 'twitter';
    }

    public function getRequest($url)
    {
        return $this->createRequest('https://cdn.api.twitter.com/1/urls/count.json?url='.urlencode($url));
    }

    public function extractCount($data)
    {
        return $data['count'];
    }
}
