<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Test\Unit\Response;

use DoclerLabs\ApiClientBase\Response\Response;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DoclerLabs\ApiClientBase\Response\Response
 */
class ResponseTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getHeaders
     * @covers ::getPayload
     * @covers ::getStatusCode
     */
    public function testEmpty()
    {
        $responseData = new Response(18);

        self::assertSame(18, $responseData->getStatusCode());
        self::assertEmpty($responseData->getHeaders());
        self::assertEmpty($responseData->getPayload());
    }

    /**
     * @covers ::__construct
     * @covers ::getHeaders
     * @covers ::getPayload
     * @covers ::getStatusCode
     */
    public function testFilled()
    {
        $body         = ['foo'];
        $headers      = ['bar'];
        $responseData = new Response(2000, $body, $headers);

        self::assertSame(2000, $responseData->getStatusCode());
        self::assertSame($headers, $responseData->getHeaders());
        self::assertSame($body, $responseData->getPayload());
    }
}
