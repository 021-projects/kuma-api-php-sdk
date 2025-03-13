<?php

namespace O21\KumaApi\Endpoints;

use O21\KumaApi\KumaApi;

class KumaEndpoint
{
    public function __construct(protected KumaApi $api) {}

    public function jsonRequest(
        string $endpoint = '',
        array $params = [],
        string $method = 'GET',
    ): mixed {
        $endpoint = rtrim($this->rootEndpoint(), '/').'/'.$endpoint;
        $endpoint = preg_replace('/\/{2,}/', '/', $endpoint);
        return $this->api->jsonRequest($endpoint, $params, $method);
    }

    public function formRequest(
        string $endpoint = '',
        array $params = [],
        string $method = 'GET',
    ): mixed {
        $endpoint = rtrim($this->rootEndpoint(), '/').'/'.$endpoint;
        $endpoint = preg_replace('/\/{2,}/', '/', $endpoint);
        return $this->api->formRequest($endpoint, $params, $method);
    }

    protected function rootEndpoint(): string
    {
        return '/';
    }
}
