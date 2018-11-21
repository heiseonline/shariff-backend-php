<?php

namespace Heise\Tests\Shariff;

use Heise\Shariff\Backend\Facebook;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * Class FacebookTest
 */
class FacebookTest extends TestCase
{
    public function testConfig()
    {
        /** @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject $client */
        $client = $this->getMockBuilder(ClientInterface::class)->getMock();
        /** @var RequestFactoryInterface|\PHPUnit_Framework_MockObject_MockObject  $requestFactory */
        $requestFactory = $this->getMockBuilder(RequestFactoryInterface::class)->getMock();

        $facebook = new Facebook($client, $requestFactory);
        $facebook->setConfig(array('app_id' => 'foo', 'secret' => 'bar'));
        $facebook->getRequest('http://www.heise.de');
    }

    public function testUsesGraphApi()
    {
        /** @var \GuzzleHttp\Client|\PHPUnit_Framework_MockObject_MockObject $client */
        $client = $this->getMockBuilder(ClientInterface::class)->getMock();
        /** @var RequestFactoryInterface|\PHPUnit_Framework_MockObject_MockObject  $requestFactory */
        $requestFactory = $this->getMockBuilder(RequestFactoryInterface::class)->getMock();

        $facebook = new Facebook($client, $requestFactory);
        $facebook->setConfig(array('app_id' => 'foo', 'secret' => 'bar'));
        $request = $facebook->getRequest('http://www.heise.de');

        $this->assertEquals('graph.facebook.com', $request->getUri()->getHost());
        $this->assertEquals('/v3.1/', $request->getUri()->getPath());
        $this->assertEquals(
            'id='.urlencode('http://www.heise.de').'&fields=engagement&access_token=foo%7Cbar',
            $request->getUri()->getQuery()
        );
    }
}
