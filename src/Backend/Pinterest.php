<?php

namespace Heise\Shariff\Backend;
use GuzzleHttp\Event\CompleteEvent;

class Pinterest extends Request implements ServiceInterface
{

    public function getName()
    {
        return 'pinterest';
    }

    public function getRequest($url)
    {
		$pinterest = 'http://api.pinterest.com/v1/urls/count.json?callback=x&url=' + $url;
        $request = $this->createRequest($pinterest);
		$request->getEmitter()->on('complete',
			function (CompleteEvent $e) {
				$body = $e->getResponse()->getBody()->getContents();
				$body = mb_substr($body, 2, mb_strlen($body) - 3);
				echo $body;
				$e->setBody($body);
				//$e->intercept($e);
			}
		return $request;
	}

    public function extractCount($data)
    {
        return $data['count'];
    }
}
