<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Response\Handler;

use DoclerLabs\ApiClientBase\Exception\BadRequestResponseException;
use DoclerLabs\ApiClientBase\Exception\ForbiddenResponseException;
use DoclerLabs\ApiClientBase\Exception\NotFoundResponseException;
use DoclerLabs\ApiClientBase\Exception\UnauthorizedResponseException;
use DoclerLabs\ApiClientBase\Exception\UnexpectedResponseException;
use DoclerLabs\ApiClientBase\Json\Json;
use DoclerLabs\ApiClientBase\Json\JsonException;
use DoclerLabs\ApiClientBase\Response\Response;
use Psr\Http\Message\ResponseInterface;

class ResponseHandler implements ResponseHandlerInterface
{
    const JSON_OPTIONS = JSON_PRESERVE_ZERO_FRACTION + JSON_BIGINT_AS_STRING;

    /**
     * @param ResponseInterface $response
     *
     * @return Response
     *
     * @throws NotFoundResponseException
     * @throws BadRequestResponseException
     * @throws UnexpectedResponseException
     * @throws JsonException
     */
    public function handle(ResponseInterface $response): Response
    {
        $statusCode = $response->getStatusCode();
        $body       = $response->getBody();
        $headers    = $response->getHeaders();

        if ($statusCode >= 200 && $statusCode < 300) {
            if ($body === null || (int)$body->getSize() === 0) {
                return new Response($statusCode, [], $headers);
            }

            $payload = Json::decode($body->__toString(), true, 512, self::JSON_OPTIONS);

            if (isset($payload['data']) && count(array_keys($payload)) === 1) {
                $payload = $payload['data'];
            }

            return new Response($statusCode, $payload, $headers);
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
