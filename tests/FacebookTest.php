<?php

namespace Heise\Tests\Shariff;

use GuzzleHttp\Message\Request;
use Heise\Shariff\Backend\Facebook;

/**
 * Class FacebookTest
 */
class FacebookTest extends \PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        /** @var \GuzzleHttp\Client|\PHPUnit_Framework_MockObject_MockObject $client */
        $client = $this->getMockBuilder('GuzzleHttp\Client')
          ->disableOriginalConstructor()
          ->getMock();

        $response = $this->getMockBuilder('GuzzleHttp\Message\ResponseInterface')
          ->getMock();

        $response
          ->method('getBody')
          ->willReturn('access_token=tokem')
        ;

        $client
          ->method('send')
          ->willReturn($response)
        ;

        $client
          ->method('createRequest')
          ->will($this->returnCallback(array($this, 'createRequest')))
        ;

        $client->expects($this->at(0))
          ->method('createRequest')
          ->with(
              'GET',
              'https://graph.facebook.com/oauth/access_token'
              . '?client_id=foo&client_secret=bar&grant_type=client_credentials'
          )
        ;

        $facebook = new Facebook($client);
        $facebook->setConfig(array('app_id' => 'foo', 'secret' => 'bar'));
        $facebook->getRequest('http://www.heise.de');
    }

    public function testUsesGraphApi()
    {
        /** @var \GuzzleHttp\Client|\PHPUnit_Framework_MockObject_MockObject $client */
        $client = $this->getMockBuilder('GuzzleHttp\\Client')
          ->disableOriginalConstructor()
          ->getMock();

        $response = $this->getMockBuilder('GuzzleHttp\\Message\\ResponseInterface')
          ->getMock();

        $response
          ->method('getBody')
          ->willReturn('access_token=token')
        ;

        $client
          ->method('send')
          ->willReturn($response)
        ;

        $client
          ->method('createRequest')
          ->will($this->returnCallback(array($this, 'createRequest')))
        ;

        $facebook = new Facebook($client);
        $facebook->setConfig(array('app_id' => 'foo', 'secret' => 'bar'));
        $url = $facebook->getRequest('http://www.heise.de')->getUrl();
        $this->assertEquals(
            'https://graph.facebook.com/v2.2/?id='.urlencode('http://www.heise.de'). '&access_token=token',
            $url
        );
    }

    /**
     * @param $method
     * @param $url
     * @param $options
     * @return Request
     */
    public function createRequest($method, $url, $options)
    {
        return new Request($method, $url, $options);
    }
}
