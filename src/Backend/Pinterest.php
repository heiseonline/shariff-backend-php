<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\Event\CompleteEvent;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

/**
 * Class Pinterest.
 */
class Pinterest extends Request implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pinterest';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest($url)
    {
        $url = 'http://api.pinterest.com/v1/urls/count.json?callback=x&url='.urlencode($url);
        $request = $this->createRequest($url);
        $request->getEmitter()->on('complete', function (CompleteEvent $e) {
            // Stripping the 'callback function' from the response
            $body = $e->getResponse()->getBody()->getContents();
            $e->intercept(new Response(200, [], (Stream::factory(mb_substr($body, 2, mb_strlen($body) - 3)))));
        });

        return $request;
    }

    /**
     * {@inheritdoc}
     */
    public function extractCount(array $data)
    {
        return isset($data['count']) ? $data['count'] : 0;
    }
}
