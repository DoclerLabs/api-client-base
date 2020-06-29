<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Test\Unit\Response\Handler;

use DoclerLabs\ApiClientBase\Exception\BadRequestResponseException;
use DoclerLabs\ApiClientBase\Exception\ForbiddenResponseException;
use DoclerLabs\ApiClientBase\Exception\NotFoundResponseException;
use DoclerLabs\ApiClientBase\Exception\UnauthorizedResponseException;
use DoclerLabs\ApiClientBase\Exception\UnexpectedResponseException;
use DoclerLabs\ApiClientBase\Response\Handler\ResponseHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @coversDefaultClass \DoclerLabs\ApiClientBase\Response\Handler\ResponseHandler
 */
class ResponseHandlerTest extends TestCase
{
    /**
     * @covers ::handle
     */
    public function testResponse()
    {
        $handler = new ResponseHandler();

        $testStatusCode = 200;
        $testRawBody    = '{"test-key":"test-value"}';
        $testBodySize   = 10;
        $expectedBody   = ['test-key' => 'test-value'];

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects($this->once())
            ->method('getSize')
            ->willReturn($testBodySize);
        $stream->expects($this->once())
            ->method('__tostring')
            ->willReturn($testRawBody);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn($testStatusCode);

        $result = $handler->handle($response);
        $this->assertEquals($expectedBody, $result);
    }

    /**
     * @covers ::handle
     */
    public function testResponseWithData()
    {
        $handler = new ResponseHandler();

        $testStatusCode = 200;
        $testRawBody    = '{"data":{"test-key":"test-value"}}';
        $testBodySize   = 10;
        $expectedBody   = ['test-key' => 'test-value'];

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects($this->once())
            ->method('getSize')
            ->willReturn($testBodySize);
        $stream->expects($this->once())
            ->method('__tostring')
            ->willReturn($testRawBody);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn($testStatusCode);

        $result = $handler->handle($response);
        $this->assertEquals($expectedBody, $result);
    }

    /**
     * @covers ::handle
     */
    public function testResponseEmpty()
    {
        $handler = new ResponseHandler();

        $testStatusCode = 200;

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn(null);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn($testStatusCode);

        $result = $handler->handle($response);
        $this->assertEquals([], $result);
    }

    /**
     * @covers ::handle
     */
    public function testResponseEmptyWhenBodySizeIsEmpty()
    {
        $handler = new ResponseHandler();

        $testStatusCode = 204;
        $testBodySize   = 0;

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects($this->once())
            ->method('getSize')
            ->willReturn($testBodySize);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn($testStatusCode);

        $result = $handler->handle($response);
        $this->assertEquals([], $result);
    }

    /**
     * @dataProvider exceptionsDataProvider
     * @covers ::handle
     */
    public function testHttpError(int $testStatusCode, string $exceptionClassName)
    {
        $handler = new ResponseHandler();

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn($testStatusCode);

        $body = $this->createMock(StreamInterface::class);
        $body->expects($this->once())
            ->method('__toString')
            ->willReturn('');

        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($body);

        $this->expectException($exceptionClassName);
        $handler->handle($response);
    }

    public function exceptionsDataProvider(): array
    {
        return [
            [400, BadRequestResponseException::class],
            [401, UnauthorizedResponseException::class],
            [403, ForbiddenResponseException::class],
            [404, NotFoundResponseException::class],
            [500, UnexpectedResponseException::class],
        ];
    }
}
