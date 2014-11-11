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
        //$twitterUrl = 'http://urls.api.twitter.com/1/urls/count.json?url=' . $url;
        $twitterUrl = 'https://cdn.api.twitter.com/1/urls/count.json?url=' . urlencode($url);
        return $this->createRequest($twitterUrl);
    }

    public function extractCount($data)
    {
        return $data['count'];
    }
}
