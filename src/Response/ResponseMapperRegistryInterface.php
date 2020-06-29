<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Response;

use Closure;
use DoclerLabs\ApiClientBase\Response\Mapper\ResponseMapperInterface;

interface ResponseMapperRegistryInterface
{
    public function add(string $schemaName, Closure $mapper);

    public function get(string $schemaName): ResponseMapperInterface;
}
