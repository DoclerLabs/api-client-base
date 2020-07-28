<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Test\Unit\Response;

use DoclerLabs\ApiClientBase\Response\ResponseData;
use phpDocumentor\Reflection\Types\Void_;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DoclerLabs\ApiClientBase\Response\ResponseData
 */
class ResponseDataTest extends TestCase
{
    /**
     * @covers ::getHeaders
     * @covers ::getPayload
     */
    public function testEmpty()
    {
        $responseData = new ResponseData();

        self::assertEmpty($responseData->getHeaders());
        self::assertEmpty($responseData->getPayload());
    }

    /**
     * @covers ::getHeaders
     * @covers ::getPayload
     */
    public function testFilled()
    {
        $body         = ['foo'];
        $headers      = ['bar'];
        $responseData = new ResponseData($body, $headers);

        self::assertSame($body, $responseData->getPayload());
        self::assertSame($headers, $responseData->getHeaders());
    }
}