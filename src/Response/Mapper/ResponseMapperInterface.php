<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Response\Mapper;

use DoclerLabs\ApiClientBase\Response\Response;

interface ResponseMapperInterface
{
    public function map(Response $response);
}
