<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Response;

class Response
{
    /** @var int */
    private $statusCode;

    /** @var array */
    private $payload;

    /** @var array */
    private $headers;

    public function __construct(int $statusCode, array $payload = [], array $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->payload    = $payload;
        $this->headers    = $headers;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}