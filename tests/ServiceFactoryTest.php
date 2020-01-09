<?php

namespace Heise\Tests\Shariff;

use GuzzleHttp\ClientInterface;
use Heise\Shariff\Backend\ServiceFactory;
use Heise\Shariff\Backend\ServiceInterface;

/**
 * Class ServiceFactoryTest
 */
class ServiceFactoryTest extends \PHPUnit\Framework\TestCase
{

    public function testSetConfig()
    {
        /** @var ServiceInterface|\PHPUnit_Framework_MockObject_MockObject $mockService */
        $mockService = $this->getMockBuilder(ServiceInterface::class)->getMock();

        $mockService->expects($this->once())
            ->method('setConfig')
            ->with(array('foo' => 'bar'))
        ;

        /** @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject $mockClient */
        $mockClient = $this->getMockBuilder(ClientInterface::class)->getMock();

        $serviceFactory = new ServiceFactory($mockClient);
        $serviceFactory->registerService('MockService', $mockService);

        $services = $serviceFactory->getServicesByName(
            array('MockService'),
            array('MockService' => array('foo' => 'bar'))
        );
        $this->assertCount(1, $services);
    }

    public function testConfigNotSet()
    {
        /** @var ServiceInterface|\PHPUnit_Framework_MockObject_MockObject $mockService */
        $mockService = $this->getMockBuilder(ServiceInterface::class)->getMock();

        $mockService->expects($this->never())->method('setConfig');

        /** @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject $mockClient */
        $mockClient = $this->getMockBuilder(ClientInterface::class)->getMock();

        $serviceFactory = new ServiceFactory($mockClient);
        $serviceFactory->registerService('MockService', $mockService);

        $services = $serviceFactory->getServicesByName(
            array('MockService'),
            array('OtherService' => array('foo' => 'bar'))
        );
        $this->assertCount(1, $services);
    }
}
