<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Request\Mapper;

use DoclerLabs\ApiClientBase\Request\RequestInterface;

interface RequestMapperInterface
{
    public function getParameters(RequestInterface $request): array;
}
