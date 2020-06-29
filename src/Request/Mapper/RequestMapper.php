<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Request\Mapper;

use DoclerLabs\ApiClientBase\Exception\RequestValidationException;
use DoclerLabs\ApiClientBase\Json\Json;
use DoclerLabs\ApiClientBase\Json\JsonException;
use DoclerLabs\ApiClientBase\Request\RequestInterface;
use GuzzleHttp\Cookie\CookieJar;

class RequestMapper implements RequestMapperInterface
{
    /**
     * @param RequestInterface $request
     *
     * @return array
     *
     * @throws RequestValidationException
     */
    public function getParameters(RequestInterface $request): array
    {
        $options = [];
        if (!empty($request->getQueryParameters())) {
            $options['query'] = $request->getQueryParameters();
        }
        if (!empty($request->getHeaders())) {
            $options['headers'] = $request->getHeaders();
        }
        if (!empty($request->getCookies())) {
            $options['cookies'] = new CookieJar(true, $request->getCookies());
        }

        try {
            if ($request->getBody() !== null) {
                $options['body'] = Json::encode($request->getBody(), 1024);
            }
        } catch (JsonException $exception) {
            throw new RequestValidationException($exception->getMessage());
        }

        return $options;
    }
}
