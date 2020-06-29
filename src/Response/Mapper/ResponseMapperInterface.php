<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Response\Mapper;

interface ResponseMapperInterface
{
    public function map(array $response);
}
