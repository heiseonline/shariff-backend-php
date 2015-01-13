<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\Event\CompleteEvent;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Message\Response;

class Pinterest extends Request implements ServiceInterface
{

    public function getName()
    {
        return 'pinterest';
    }

    public function getRequest($url)
    {
        $url = 'http://api.pinterest.com/v1/urls/count.json?callback=x&url='.urlencode($url);
        $request = $this->createRequest($url);
        $request->getEmitter()->on('complete', function (CompleteEvent $e) {
            // Stripping the 'callback function' from the response
            $body = $e->getResponse()->getBody()->getContents();
            $e->intercept(new Response(200, array(), (Stream::factory(mb_substr($body, 2, mb_strlen($body) - 3)))));
        });
        return $request;
    }

    public function extractCount($data)
    {
        return $data['count'];
    }
}
