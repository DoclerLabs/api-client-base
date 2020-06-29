<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Test\Unit\Exception;

use DoclerLabs\ApiClientBase\Exception\UnexpectedResponseBodyException;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * @coversDefaultClass \DoclerLabs\ApiClientBase\Exception\UnexpectedResponseBodyException
 */
class UnexpectedResponseBodyExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testException()
    {
        $exception = new UnexpectedResponseBodyException();
        $this->assertInstanceOf(Throwable::class, $exception);
    }
}
