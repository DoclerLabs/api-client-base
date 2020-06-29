<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Request;

interface RequestInterface
{
    public function getMethod(): string;

    public function getRoute(): string;

    public function getCookies(): array;

    public function getHeaders(): array;

    public function getQueryParameters(): array;

    public function getBody();
}
