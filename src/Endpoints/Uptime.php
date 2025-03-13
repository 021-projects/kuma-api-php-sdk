<?php

namespace O21\KumaApi\Endpoints;

class Uptime extends KumaEndpoint
{
    public function get(?int $id = null): array
    {
        $endpoint = $id ?: '';

        return $this->jsonRequest($endpoint);
    }

    protected function rootEndpoint(): string
    {
        return 'uptime';
    }
}
