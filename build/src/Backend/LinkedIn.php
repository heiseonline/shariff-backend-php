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
        return $this->createRequest('https://www.linkedin.com/countserv/count/share?url=' . urlencode($url). '&lang=de_DE&format=json');
    }

    public function extractCount($data)
    {
        return $data['count'];
    }
}
