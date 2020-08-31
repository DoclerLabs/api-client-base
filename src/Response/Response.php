<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Response;

class Response
{
    /** @var int */
    private $statusCode;

    /** @var array */
    private $headers;

    /** @var array */
    private $payload;

    public function __construct(int $statusCode, array $headers = [], $payload = null)
    {
        $this->statusCode = $statusCode;
        $this->headers    = $headers;
        $this->payload    = $payload;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getPayload()
    {
        return $this->payload;
    }
}
