<?php

namespace Heise\Shariff\Backend;

class Flattr extends Request implements ServiceInterface
{

    public function getName()
    {
        return 'flattr';
    }

    public function getRequest($url)
    {
        $url = 'https://api.flattr.com/rest/v2/things/lookup/?url='.urlencode($url);
        return $this->createRequest($url);
    }

    public function extractCount($data)
    {
        return (isset($data['flattrs'])) ? $data['flattrs'] : 0;
    }
}
