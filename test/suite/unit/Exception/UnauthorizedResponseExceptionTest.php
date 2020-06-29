<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Test\Unit\Exception;

use DoclerLabs\ApiClientBase\Exception\UnauthorizedResponseException;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * @coversDefaultClass \DoclerLabs\ApiClientBase\Exception\UnauthorizedResponseException
 */
class UnauthorizedResponseExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getStatusCode
     * @covers ::getMessage
     */
    public function testException()
    {
        $statusCode = 401;
        $sut        = new UnauthorizedResponseException();

        $this->assertInstanceOf(Throwable::class, $sut);
        $this->assertEquals($statusCode, $sut->getStatusCode());
    }
}
