<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Test\Unit\Request\Mapper;

use DoclerLabs\ApiClientBase\Exception\RequestValidationException;
use DoclerLabs\ApiClientBase\Request\Mapper\RequestMapper;
use DoclerLabs\ApiClientBase\Request\RequestInterface;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DoclerLabs\ApiClientBase\Request\Mapper\RequestMapper
 */
class RequestMapperTest extends TestCase
{
    /**
     * @covers ::getParameters
     */
    public function testGetParameters()
    {
        $handler = new RequestMapper();

        $testGetQueryParameters = [
            'id' => 'ewgrfbd',
        ];
        $testGetHeaders         = [
            'header' => '3e',
        ];
        $testGetCookies         = [
            ['cookie' => '5er'],
        ];
        $testGetBody            = [];

        $request = $this->createMock(RequestInterface::class);
        $request->expects($this->exactly(2))
            ->method('getQueryParameters')
            ->willReturn($testGetQueryParameters);
        $request->expects($this->exactly(2))
            ->method('getHeaders')
            ->willReturn($testGetHeaders);
        $request->expects($this->exactly(2))
            ->method('getCookies')
            ->willReturn($testGetCookies);
        $request->expects($this->exactly(2))
            ->method('getBody')
            ->willReturn($testGetBody);

        $parameters = $handler->getParameters($request);
        $this->assertEquals($testGetQueryParameters, $parameters['query']);
    }

    /**
     * @covers ::getParameters
     */
    public function testInvalidBody()
    {
        $handler = new RequestMapper();

        $request = $this->createMock(RequestInterface::class);
        $request->expects($this->once())
            ->method('getQueryParameters')
            ->willReturn([]);
        $request->expects($this->once())
            ->method('getHeaders')
            ->willReturn([]);
        $request->expects($this->once())
            ->method('getCookies')
            ->willReturn([]);
        $request->expects($this->exactly(2))
            ->method('getBody')
            ->willReturn(urldecode('bad utf string %C4_'));

        $this->expectException(RequestValidationException::class);
        $handler->getParameters($request);
    }
}
