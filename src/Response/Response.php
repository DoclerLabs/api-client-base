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

    /**
     * @return array
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}