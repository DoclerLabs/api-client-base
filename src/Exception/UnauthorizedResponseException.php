<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Exception;

class UnauthorizedResponseException extends UnexpectedResponseException
{
    public function __construct(string $serializedErrors = '')
    {
        parent::__construct(401, $serializedErrors);
    }

    public function getStatusCode(): int
    {
        return 401;
    }
}
