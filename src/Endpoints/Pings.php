<?php

namespace O21\KumaApi\Endpoints;

class Pings extends KumaEndpoint
{
    public function get(?int $monitorId = null): array|int|null
    {
        $endpoint = $monitorId ?: '';

        return $this->jsonRequest($endpoint);
    }

    protected function rootEndpoint(): string
    {
        return '/pings';
    }
}
