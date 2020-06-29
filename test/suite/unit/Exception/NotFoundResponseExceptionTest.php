<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Test\Unit\Exception;

use DoclerLabs\ApiClientBase\Exception\NotFoundResponseException;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * @coversDefaultClass \DoclerLabs\ApiClientBase\Exception\NotFoundResponseException
 */
class NotFoundResponseExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getStatusCode
     * @covers ::getMessage
     */
    public function testException()
    {
        $statusCode = 404;
        $sut        = new NotFoundResponseException();

        $this->assertInstanceOf(Throwable::class, $sut);
        $this->assertEquals($statusCode, $sut->getStatusCode());
    }
}
