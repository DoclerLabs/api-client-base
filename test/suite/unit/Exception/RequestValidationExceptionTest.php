<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Test\Unit\Exception;

use DoclerLabs\ApiClientBase\Exception\RequestValidationException;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * @coversDefaultClass \DoclerLabs\ApiClientBase\Exception\RequestValidationException
 */
class RequestValidationExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testException()
    {
        $exception = new RequestValidationException();
        $this->assertInstanceOf(Throwable::class, $exception);
    }
}
