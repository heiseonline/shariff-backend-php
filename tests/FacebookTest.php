<?php

namespace Heise\Tests\Shariff;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Heise\Shariff\Backend\Facebook;
use PHPUnit\Framework as PHPUnit;

/**
 * Class FacebookTest
 */
class FacebookTest extends PHPUnit\TestCase
{
    public function testConfig()
    {
        /** @var ClientInterface|PHPUnit\MockObject\MockObject $client */
        $client = $this->getMockBuilder(ClientInterface::class)->getMock();

        $facebook = new Facebook($client);
        $facebook->setConfig(['app_id' => 'foo', 'secret' => 'bar']);
        $request = $facebook->getRequest('https://www.heise.de');
        $this->assertEquals(
            'id=' . urlencode('https://www.heise.de') . '&fields=engagement&access_token=foo%7Cbar',
            $request->getUri()->getQuery()
        );
    }

    public function testUsesGraphApi()
    {
        /** @var Client|PHPUnit\MockObject\MockObject $client */
        $client = $this->getMockBuilder(ClientInterface::class)->getMock();

        $facebook = new Facebook($client);
        $facebook->setConfig(['app_id' => 'foo', 'secret' => 'bar']);
        $request = $facebook->getRequest('https://www.heise.de');

        $this->assertEquals('graph.facebook.com', $request->getUri()->getHost());
        $this->assertEquals('/v7.0/', $request->getUri()->getPath());
        $this->assertEquals(
            'id=' . urlencode('https://www.heise.de') . '&fields=engagement&access_token=foo%7Cbar',
            $request->getUri()->getQuery()
        );
    }
}
