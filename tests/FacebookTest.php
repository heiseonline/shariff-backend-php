<?php

namespace Heise\Tests\Shariff;

use GuzzleHttp\ClientInterface;
use Heise\Shariff\Backend\Facebook;
use Psr\Http\Message\ResponseInterface;

/**
 * Class FacebookTest
 */
class FacebookTest extends \PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        /** @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject $client */
        $client = $this->getMock(ClientInterface::class);

        $response = $this->getMock(ResponseInterface::class);

        $response
          ->method('getBody')
          ->willReturn('access_token=tokem')
        ;

        $client->expects($this->at(0))
          ->method('request')
          ->with(
              'GET',
              'https://graph.facebook.com/oauth/access_token'
              . '?client_id=foo&client_secret=bar&grant_type=client_credentials'
          )
          ->willReturn($response)
        ;

        $facebook = new Facebook($client);
        $facebook->setConfig(array('app_id' => 'foo', 'secret' => 'bar'));
        $facebook->getRequest('http://www.heise.de');
    }

    public function testUsesGraphApi()
    {
        /** @var \GuzzleHttp\Client|\PHPUnit_Framework_MockObject_MockObject $client */
        $client = $this->getMock(ClientInterface::class);

        $response = $this->getMock(ResponseInterface::class);

        $response
          ->method('getBody')
          ->willReturn('access_token=token')
        ;

        $client->expects($this->once())
            ->method('request')
            ->willReturn($response)
        ;

        $facebook = new Facebook($client);
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
