<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Test\Unit\Response\Handler;

use DoclerLabs\ApiClientBase\Exception\BadRequestResponseException;
use DoclerLabs\ApiClientBase\Exception\ForbiddenResponseException;
use DoclerLabs\ApiClientBase\Exception\NotFoundResponseException;
use DoclerLabs\ApiClientBase\Exception\UnauthorizedResponseException;
use DoclerLabs\ApiClientBase\Exception\UnexpectedResponseException;
use DoclerLabs\ApiClientBase\Response\Handler\ResponseHandler;
use DoclerLabs\ApiClientBase\Response\Response;
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
     * @covers ::isResponseBodyEmpty
     */
    public function testResponse()
    {
        $handler = new ResponseHandler();

        $testStatusCode  = 200;
        $testRawBody     = '{"test-key":"test-value"}';
        $testHeaders     = ['X-Foo' => 'bar'];
        $testBodySize    = 10;
        $expectedBody    = ['test-key' => 'test-value'];
        $expectedHeaders = $testHeaders;

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getSize')
            ->willReturn($testBodySize);
        $stream->expects(self::once())
            ->method('__tostring')
            ->willReturn($testRawBody);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);
        $response->expects(self::once())
            ->method('getStatusCode')
            ->willReturn($testStatusCode);
        $response->expects(self::once())
            ->method('getHeaders')
            ->willReturn($testHeaders);

        $result = $handler->handle($response);

        self::assertEquals($expectedBody, $result->getPayload());
        self::assertEquals($expectedHeaders, $result->getHeaders());
    }

    /**
     * @covers ::handle
     * @covers ::isResponseBodyEmpty
     */
    public function testResponseWithDataAndExtraFields()
    {
        $handler = new ResponseHandler();

        $testStatusCode  = 200;
        $testRawBody     = '{"data":{"test-key":"test-value"},"total":1}';
        $testHeaders     = ['X-Foo' => 'bar'];
        $testBodySize    = 10;
        $expectedBody    = ['data' => ['test-key' => 'test-value'], 'total' => 1];
        $expectedHeaders = $testHeaders;

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getSize')
            ->willReturn($testBodySize);
        $stream->expects(self::once())
            ->method('__tostring')
            ->willReturn($testRawBody);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);
        $response->expects(self::once())
            ->method('getStatusCode')
            ->willReturn($testStatusCode);
        $response->expects(self::once())
            ->method('getHeaders')
            ->willReturn($testHeaders);

        $result = $handler->handle($response);

        self::assertEquals($expectedBody, $result->getPayload());
        self::assertEquals($expectedHeaders, $result->getHeaders());
    }

    /**
     * @covers ::handle
     * @covers ::isResponseBodyEmpty
     */
    public function testResponseWithData()
    {
        $handler = new ResponseHandler();

        $testStatusCode  = 200;
        $testRawBody     = '{"data":{"test-key":"test-value"}}';
        $testHeaders     = ['X-Foo' => 'bar'];
        $testBodySize    = 10;
        $expectedBody    = ['data' => ['test-key' => 'test-value']];
        $expectedHeaders = $testHeaders;

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getSize')
            ->willReturn($testBodySize);
        $stream->expects(self::once())
            ->method('__tostring')
            ->willReturn($testRawBody);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);
        $response->expects(self::once())
            ->method('getStatusCode')
            ->willReturn($testStatusCode);
        $response->expects(self::once())
            ->method('getHeaders')
            ->willReturn($testHeaders);

        $result = $handler->handle($response);

        self::assertEquals($expectedHeaders, $result->getHeaders());
        self::assertEquals($expectedBody, $result->getPayload());
    }

    /**
     * @covers ::handle
     * @covers ::isResponseBodyEmpty
     */
    public function testResponseEmpty()
    {
        $handler = new ResponseHandler();

        $testStatusCode = 200;

        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn(null);
        $response->expects(self::once())
            ->method('getStatusCode')
            ->willReturn($testStatusCode);
        $response->expects(self::once())
            ->method('getHeaders')
            ->willReturn([]);

        $result = $handler->handle($response);

        self::assertEquals([], $result->getHeaders());
        self::assertNull($result->getPayload());
    }

    /**
     * @covers ::handle
     * @covers ::isResponseBodyEmpty
     */
    public function testResponseEmptyWhenBodySizeIsEmpty()
    {
        $handler = new ResponseHandler();

        $testStatusCode = 204;
        $testBodySize   = 0;

        $stream = $this->createMock(StreamInterface::class);
        $stream->expects(self::once())
            ->method('getSize')
            ->willReturn($testBodySize);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($stream);
        $response->expects(self::once())
            ->method('getStatusCode')
            ->willReturn($testStatusCode);
        $response->expects(self::once())
            ->method('getHeaders')
            ->willReturn([]);

        $result = $handler->handle($response);

        self::assertEquals([], $result->getHeaders());
        self::assertNull($result->getPayload());
    }

    /**
     * @dataProvider exceptionsDataProvider
     * @covers ::handle
     * @covers ::isResponseBodyEmpty
     */
    public function testHttpError(int $testStatusCode, string $exceptionClassName)
    {
        $handler = new ResponseHandler();

        $response = $this->createMock(ResponseInterface::class);
        $response->expects(self::once())
            ->method('getStatusCode')
            ->willReturn($testStatusCode);

        $body = $this->createMock(StreamInterface::class);
        $body->expects(self::once())
            ->method('getSize')
            ->willReturn(20);

        $body->expects(self::once())
            ->method('__toString')
            ->willReturn(json_encode(['error' => 'something went wrong']));

        $response->expects(self::once())
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
