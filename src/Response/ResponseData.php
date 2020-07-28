<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Response;

class ResponseData
{
    /** @var array */
    private $payload;

    /** @var array */
    private $headers;

    public function __construct(array $payload = [], array $headers = [])
    {
        $this->payload = $payload;
        $this->headers = $headers;
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