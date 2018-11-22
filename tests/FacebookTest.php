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
        $client = $this->createMock(ClientInterface::class);
        /** @var RequestFactoryInterface|\PHPUnit_Framework_MockObject_MockObject $requestFactory */
        $requestFactory = $this->createMock(RequestFactoryInterface::class);

        $facebook = new Facebook($client, $requestFactory);
        $facebook->setConfig(array('app_id' => 'foo', 'secret' => 'bar'));
        $facebook->getRequest('http://www.heise.de');
    }

    public function testUsesGraphApi()
    {
        /** @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject $client */
        $client = $this->createMock(ClientInterface::class);
        /** @var RequestFactoryInterface|\PHPUnit_Framework_MockObject_MockObject $requestFactory */
        $requestFactory = $this->createMock(RequestFactoryInterface::class);

        $requestFactory->expects($this->once())->method('createRequest')
            ->with('GET', 'https://graph.facebook.com/v3.1/?id='.
                urlencode('http://www.heise.de') .
                '&fields=engagement&access_token=foo|bar');

        $facebook = new Facebook($client, $requestFactory);
        $facebook->setConfig(array('app_id' => 'foo', 'secret' => 'bar'));
        $facebook->getRequest('http://www.heise.de');
    }
}
