<?php

namespace Heise\Tests\Shariff;

use Heise\Shariff\Backend\ServiceFactory;
use Heise\Shariff\Backend\ServiceInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * Class ServiceFactoryTest
 */
class ServiceFactoryTest extends TestCase
{

    public function testSetConfig()
    {
        /** @var ServiceInterface|\PHPUnit_Framework_MockObject_MockObject $mockService */
        $mockService = $this->createMock(ServiceInterface::class);

        $mockService->expects($this->once())
            ->method('setConfig')
            ->with(array('foo' => 'bar'))
        ;

        /** @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject $mockClient */
        $mockClient = $this->createMock(ClientInterface::class);
        $mockFactory = $this->createMock(RequestFactoryInterface::class);

        $serviceFactory = new ServiceFactory($mockClient, $mockFactory);
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
        $mockService = $this->createMock(ServiceInterface::class);
        $mockFactory = $this->createMock(RequestFactoryInterface::class);

        $mockService->expects($this->never())->method('setConfig');

        /** @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject $mockClient */
        $mockClient = $this->createMock(ClientInterface::class);

        $serviceFactory = new ServiceFactory($mockClient, $mockFactory);
        $serviceFactory->registerService('MockService', $mockService);

        $services = $serviceFactory->getServicesByName(
            array('MockService'),
            array('OtherService' => array('foo' => 'bar'))
        );
        $this->assertCount(1, $services);
    }
}
