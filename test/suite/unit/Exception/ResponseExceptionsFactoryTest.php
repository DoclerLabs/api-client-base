<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Test\Unit\Exception;

use DoclerLabs\ApiClientBase\Exception\BadRequestResponseException;
use DoclerLabs\ApiClientBase\Exception\ForbiddenResponseException;
use DoclerLabs\ApiClientBase\Exception\NotFoundResponseException;
use DoclerLabs\ApiClientBase\Exception\PaymentRequiredResponseException;
use DoclerLabs\ApiClientBase\Exception\ResponseExceptionFactory;
use DoclerLabs\ApiClientBase\Exception\UnauthorizedResponseException;
use DoclerLabs\ApiClientBase\Exception\UnexpectedResponseException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DoclerLabs\ApiClientBase\Exception\ResponseExceptionFactory
 */
class ResponseExceptionsFactoryTest extends TestCase
{
    /**
     * @dataProvider exceptionsDataProvider
     * @covers ::__construct
     * @covers ::create
     */
    public function testCreate(int $statusCode, string $body, string $expectedExceptionClass)
    {
        $sut = new ResponseExceptionFactory();

        $this->expectException($expectedExceptionClass);

        throw $sut->create($statusCode, $body);
    }

    public function exceptionsDataProvider(): array
    {
        return [
            [400, 'bad request', BadRequestResponseException::class],
            [401, 'unauthorized', UnauthorizedResponseException::class],
            [402, 'payment required', PaymentRequiredResponseException::class],
            [403, 'forbidden', ForbiddenResponseException::class],
            [404, 'not found', NotFoundResponseException::class],
            [456, 'others', UnexpectedResponseException::class],
        ];
    }
}