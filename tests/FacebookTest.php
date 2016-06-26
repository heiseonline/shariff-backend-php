<?php

namespace Heise\Tests\Shariff;

use Heise\Shariff\Backend\Facebook;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class FacebookTest
 */
class FacebookTest extends \PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        /** @var HttpClient|\PHPUnit_Framework_MockObject_MockObject $client */
        $client = $this->getMock(HttpClient::class);

        /** @var MessageFactory\\PHPUnit_Framework_MockObject_MockObject $messageFactory */
        $messageFactory = $this->getMock(MessageFactory::class);

        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();

        $response
          ->method('getBody')
          ->willReturn('access_token=tokem')
        ;

        $request = $this->getMock(RequestInterface::class);

        $messageFactory->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                'https://graph.facebook.com/oauth/access_token'
                . '?client_id=foo&client_secret=bar&grant_type=client_credentials'
            )
            ->willReturn($request);

        $client->expects($this->at(0))
          ->method('sendRequest')
          ->with($request)
          ->willReturn($response)
        ;

        $facebook = new Facebook($client, $messageFactory);
        $facebook->setConfig(array('app_id' => 'foo', 'secret' => 'bar'));
        $facebook->getRequest('http://www.heise.de');
    }

    public function testUsesGraphApi()
    {
        /** @var HttpClient|\PHPUnit_Framework_MockObject_MockObject $client */
        $client = $this->getMock(HttpClient::class);

        /** @var MessageFactory\\PHPUnit_Framework_MockObject_MockObject $messageFactory */
        $messageFactory = $this->getMock(MessageFactory::class);

        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();

        $response
          ->method('getBody')
          ->willReturn('access_token=token')
        ;

        $request = $this->getMock(RequestInterface::class);

        $messageFactory->expects($this->once())
            ->method('createRequest')
            ->willReturn($request);

        $client->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response)
        ;

        $facebook = new Facebook($client, $messageFactory);
        $facebook->setConfig(array('app_id' => 'foo', 'secret' => 'bar'));
        $request = $facebook->getRequest('http://www.heise.de');

        $this->assertEquals('graph.facebook.com', $request->getUri()->getHost());
        $this->assertEquals('/v2.2/', $request->getUri()->getPath());
        $this->assertEquals(
            'id='.urlencode('http://www.heise.de').'&access_token=token',
            $request->getUri()->getQuery()
        );
    }
}
