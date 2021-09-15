<?php

namespace Heise\Tests\Shariff;

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
        $facebook->setConfig(array('app_id' => 'foo', 'secret' => 'bar'));
        $request = $facebook->getRequest('http://www.heise.de');
        $this->assertEquals(
            'id='.urlencode('http://www.heise.de').'&fields=engagement&access_token=foo%7Cbar',
            $request->getUri()->getQuery()
        );
    }

    public function testUsesGraphApi()
    {
        /** @var \GuzzleHttp\Client|PHPUnit\MockObject\MockObject $client */
        $client = $this->getMockBuilder(ClientInterface::class)->getMock();

        $facebook = new Facebook($client);
        $facebook->setConfig(array('app_id' => 'foo', 'secret' => 'bar'));
        $request = $facebook->getRequest('http://www.heise.de');

        $this->assertEquals('graph.facebook.com', $request->getUri()->getHost());
        $this->assertEquals('/v11.0/', $request->getUri()->getPath());
        $this->assertEquals(
            'id='.urlencode('http://www.heise.de').'&fields=og_object%7Bengagement%7D&access_token=foo%7Cbar',
            $request->getUri()->getQuery()
        );
    }
}
