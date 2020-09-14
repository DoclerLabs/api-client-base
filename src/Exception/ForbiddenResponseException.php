<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Exception;

class ForbiddenResponseException extends UnexpectedResponseException
{
    const STATUS_CODE = 403;

    public function __construct(string $serializedErrors = '')
    {
        parent::__construct(self::STATUS_CODE, $serializedErrors);
    }

    public function getStatusCode(): int
    {
        return self::STATUS_CODE;
    }
}
