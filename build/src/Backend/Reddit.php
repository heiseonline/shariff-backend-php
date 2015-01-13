<?php

namespace Heise\Shariff\Backend;

class Reddit extends Request implements ServiceInterface
{

    public function getName()
    {
        return 'reddit';
    }

    public function getRequest($url)
    {
        return $this->createRequest('https://www.reddit.com/api/info.json?url='.urlencode($url));
    }

    public function extractCount($data)
    {
        $count = 0;
        foreach ($data['data']['children'] as $child) {
            $count += $child['data']['score'];
        }
        return $count;
    }
}
