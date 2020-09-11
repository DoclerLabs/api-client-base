<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Exception;

class ResponseExceptionFactory
{
    /** @var string[] */
    private $responseExceptions;

    public function __construct()
    {
        $this->responseExceptions = [
            BadRequestResponseException::STATUS_CODE      => BadRequestResponseException::class,
            UnauthorizedResponseException::STATUS_CODE    => UnauthorizedResponseException::class,
            PaymentRequiredResponseException::STATUS_CODE => PaymentRequiredResponseException::class,
            ForbiddenResponseException::STATUS_CODE       => ForbiddenResponseException::class,
            NotFoundResponseException::STATUS_CODE        => NotFoundResponseException::class,
        ];
    }

    public function create(int $statusCode, string $responseBody): UnexpectedResponseException
    {
        if (isset($this->responseExceptions[$statusCode])) {
            return new $this->responseExceptions[$statusCode]($responseBody);
        }

        return new UnexpectedResponseException($statusCode, $responseBody);
    }
}