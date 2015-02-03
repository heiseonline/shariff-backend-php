<?php

namespace Heise\Tests\Shariff;

use GuzzleHttp\Client;
use Heise\Shariff\Backend\ServiceFactory;

class ServiceFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testSetConfig()
    {
        $mockService = $this->getMockBuilder('Heise\Shariff\Backend\ServiceInterface')
            ->getMock();

        $mockService->expects($this->once())
            ->method('setConfig')
            ->with(array('foo' => 'bar'))
        ;

        $serviceFactory = new ServiceFactory(new Client());
        $serviceFactory->registerService('MockService', $mockService);

        $services = $serviceFactory->getServicesByName(
            array('MockService'),
            array('MockService' => array('foo' => 'bar'))
        );
        $this->assertCount(1, $services);
    }

    public function testConfigNotSet()
    {
        $mockService = $this->getMockBuilder('Heise\Shariff\Backend\ServiceInterface')
          ->getMock();

        $mockService->expects($this->never())
          ->method('setConfig')
        ;

        $serviceFactory = new ServiceFactory(new Client());
        $serviceFactory->registerService('MockService', $mockService);

        $services = $serviceFactory->getServicesByName(
            array('MockService'),
            array('OtherService' => array('foo' => 'bar'))
        );
        $this->assertCount(1, $services);
    }
}
