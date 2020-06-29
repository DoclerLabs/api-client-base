<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Exception;

class NotFoundResponseException extends UnexpectedResponseException
{
    public function __construct(string $serializedErrors = '')
    {
        parent::__construct(404, $serializedErrors);
    }

    public function getStatusCode(): int
    {
        return 404;
    }
}
