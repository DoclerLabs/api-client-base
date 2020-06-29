<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Test\Unit\Exception;

use DoclerLabs\ApiClientBase\Exception\ForbiddenResponseException;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * @coversDefaultClass \DoclerLabs\ApiClientBase\Exception\ForbiddenResponseException
 */
class ForbiddenResponseExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getStatusCode
     */
    public function testException()
    {
        $statusCode = 403;
        $sut        = new ForbiddenResponseException();

        $this->assertInstanceOf(Throwable::class, $sut);
        $this->assertEquals($statusCode, $sut->getStatusCode());
    }
}
