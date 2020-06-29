<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Test\Unit\Exception;

use DoclerLabs\ApiClientBase\Exception\UnexpectedResponseException;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * @coversDefaultClass \DoclerLabs\ApiClientBase\Exception\UnexpectedResponseException
 */
class UnexpectedResponseExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getStatusCode
     * @covers ::getMessage
     */
    public function testException()
    {
        $statusCode = 414;
        $errors     = '{"it": "happens"}';
        $sut        = new UnexpectedResponseException($statusCode, $errors);

        $this->assertInstanceOf(Throwable::class, $sut);
        $this->assertEquals($statusCode, $sut->getStatusCode());
        $this->assertEquals(
            \sprintf('Server replied with a non-200 status code: %s | %s', $statusCode, $errors),
            $sut->getMessage()
        );
    }
}
