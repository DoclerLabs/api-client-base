<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Exception;

class ForbiddenResponseException extends UnexpectedResponseException
{
    public function __construct(string $serializedErrors = '')
    {
        parent::__construct(403, $serializedErrors);
    }

    public function getStatusCode(): int
    {
        return 403;
    }
}
