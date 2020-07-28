<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Response\Mapper;

use DoclerLabs\ApiClientBase\Response\ResponseData;

interface ResponseMapperInterface
{
    public function map(ResponseData $responseData);
}
