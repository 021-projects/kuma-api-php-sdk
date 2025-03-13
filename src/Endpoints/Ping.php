<?php

namespace O21\KumaApi\Endpoints;

class Ping extends KumaEndpoint
{
    public function avg(?int $monitorId = null): array|int|null
    {
        $endpoint = $monitorId ?: '';

        return $this->jsonRequest($endpoint);
    }

    protected function rootEndpoint(): string
    {
        return '/ping';
    }
}
