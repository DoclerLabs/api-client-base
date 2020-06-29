<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Response\Handler;

use DoclerLabs\ApiClientBase\Exception\BadRequestResponseException;
use DoclerLabs\ApiClientBase\Exception\ForbiddenResponseException;
use DoclerLabs\ApiClientBase\Exception\NotFoundResponseException;
use DoclerLabs\ApiClientBase\Exception\UnauthorizedResponseException;
use DoclerLabs\ApiClientBase\Exception\UnexpectedResponseException;
use DoclerLabs\ApiClientBase\Json\Json;
use DoclerLabs\ApiClientBase\Json\JsonException;
use Psr\Http\Message\ResponseInterface;

class ResponseHandler implements ResponseHandlerInterface
{
    const JSON_OPTIONS = JSON_PRESERVE_ZERO_FRACTION + JSON_BIGINT_AS_STRING;

    /**
     * @param ResponseInterface $response
     *
     * @return array
     *
     * @throws NotFoundResponseException
     * @throws BadRequestResponseException
     * @throws UnexpectedResponseException
     * @throws JsonException
     */
    public function handle(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();
        $body       = $response->getBody();

        if ($statusCode >= 200 && $statusCode < 300) {
            if ($body === null || (int)$body->getSize() === 0) {
                return [];
            }

            $payload = Json::decode($body->__toString(), true, 512, self::JSON_OPTIONS);

            if (isset($payload['data'])) {
                $payload = $payload['data'];
            }

            return $payload;
        }

        $errorPayload = '';
        if ($body !== null) {
            $errorPayload = (string)$body;
        }

        if ($statusCode === 400) {
            throw new BadRequestResponseException($errorPayload);
        }

        if ($statusCode === 401) {
            throw new UnauthorizedResponseException($errorPayload);
        }

        if ($statusCode === 403) {
            throw new ForbiddenResponseException($errorPayload);
        }

        if ($statusCode === 404) {
            throw new NotFoundResponseException($errorPayload);
        }

        throw new UnexpectedResponseException($statusCode, $errorPayload);
    }
}
