<?php

namespace Heise\Tests\Shariff;

use GuzzleHttp\ClientInterface;
use Heise\Shariff\Backend\ServiceFactory;
use Heise\Shariff\Backend\ServiceInterface;
use PHPUnit\Framework as PHPUnit;

/**
 * Class ServiceFactoryTest
 */
class ServiceFactoryTest extends PHPUnit\TestCase
{

    public function testSetConfig()
    {
        /** @var ServiceInterface|PHPUnit\MockObject\MockObject $mockService */
        $mockService = $this->getMockBuilder(ServiceInterface::class)->getMock();

        $mockService->expects($this->once())
            ->method('setConfig')
            ->with(['foo' => 'bar']);

        /** @var ClientInterface|PHPUnit\MockObject\MockObject $mockClient */
        $mockClient = $this->getMockBuilder(ClientInterface::class)->getMock();

        $serviceFactory = new ServiceFactory($mockClient);
        $serviceFactory->registerService('MockService', $mockService);

        $services = $serviceFactory->getServicesByName(
            ['MockService'],
            ['MockService' => ['foo' => 'bar']]
        );
        $this->assertCount(1, $services);
    }

    public function testConfigNotSet()
    {
        /** @var ServiceInterface|PHPUnit\MockObject\MockObject $mockService */
        $mockService = $this->getMockBuilder(ServiceInterface::class)->getMock();

        $mockService->expects($this->never())->method('setConfig');

        /** @var ClientInterface|PHPUnit\MockObject\MockObject $mockClient */
        $mockClient = $this->getMockBuilder(ClientInterface::class)->getMock();

        $serviceFactory = new ServiceFactory($mockClient);
        $serviceFactory->registerService('MockService', $mockService);

        $services = $serviceFactory->getServicesByName(
            ['MockService'],
            ['OtherService' => ['foo' => 'bar']]
        );
        $this->assertCount(1, $services);
    }
}
