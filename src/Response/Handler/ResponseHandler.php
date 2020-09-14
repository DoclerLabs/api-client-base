<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Response\Handler;

use DoclerLabs\ApiClientBase\Exception\BadRequestResponseException;
use DoclerLabs\ApiClientBase\Exception\ForbiddenResponseException;
use DoclerLabs\ApiClientBase\Exception\NotFoundResponseException;
use DoclerLabs\ApiClientBase\Exception\PaymentRequiredResponseException;
use DoclerLabs\ApiClientBase\Exception\ResponseExceptionFactory;
use DoclerLabs\ApiClientBase\Exception\UnauthorizedResponseException;
use DoclerLabs\ApiClientBase\Exception\UnexpectedResponseException;
use DoclerLabs\ApiClientBase\Json\Json;
use DoclerLabs\ApiClientBase\Json\JsonException;
use DoclerLabs\ApiClientBase\Response\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResponseHandler implements ResponseHandlerInterface
{
    const JSON_OPTIONS = JSON_PRESERVE_ZERO_FRACTION + JSON_BIGINT_AS_STRING;

    /** @var ResponseExceptionFactory */
    private $responseExceptionsFactory;

    public function __construct()
    {
        $this->responseExceptionsFactory = new ResponseExceptionFactory();
    }

    /**
     * @param ResponseInterface $response
     *
     * @return Response
     *
     * @throws BadRequestResponseException
     * @throws UnauthorizedResponseException
     * @throws PaymentRequiredResponseException
     * @throws ForbiddenResponseException
     * @throws NotFoundResponseException
     * @throws UnexpectedResponseException
     * @throws JsonException
     */
    public function handle(ResponseInterface $response): Response
    {
        $statusCode          = $response->getStatusCode();
        $body                = $response->getBody();
        $headers             = $response->getHeaders();
        $isResponseBodyEmpty = $this->isResponseBodyEmpty($body);
        $responseBody        = '';

        if (!$isResponseBodyEmpty) {
            $responseBody = (string)$body;
        }

        if ($statusCode >= 200 && $statusCode < 300) {
            if ($isResponseBodyEmpty) {
                return new Response($statusCode, null, $headers);
            }

            $decodedPayload = Json::decode($responseBody, true, 512, self::JSON_OPTIONS);

            return new Response($statusCode, $decodedPayload, $headers);
        }

        throw $this->responseExceptionsFactory->create($statusCode, $responseBody);
    }

    private function isResponseBodyEmpty(StreamInterface $responseBody = null): bool
    {
        return $responseBody === null || (int)$responseBody->getSize() === 0;
    }
}
