<?php
namespace Heise\Shariff\Backend;

class LinkedIn extends Request implements ServiceInterface
{

    public function getName()
    {
        return 'linkedin';
    }

    public function getRequest($url)
    {
        $linkedin = 'https://www.linkedin.com/countserv/count/share?url=' . urlencode($url). '&lang=de_DE&format=json';
        return $this->createRequest($linkedin);
    }

    public function extractCount($data)
    {
        return $data['count'];
    }
}
