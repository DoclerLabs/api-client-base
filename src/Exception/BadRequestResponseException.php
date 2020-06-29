<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Exception;

class BadRequestResponseException extends UnexpectedResponseException
{
    public function __construct(string $serializedErrors = '')
    {
        parent::__construct(400, $serializedErrors);
    }

    public function getStatusCode(): int
    {
        return 400;
    }
}
