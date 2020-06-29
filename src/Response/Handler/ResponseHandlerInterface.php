<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Response\Handler;

use Psr\Http\Message\ResponseInterface;

interface ResponseHandlerInterface
{
    public function handle(ResponseInterface $response): array;
}
