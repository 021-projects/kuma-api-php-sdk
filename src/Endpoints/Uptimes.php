<?php

namespace O21\KumaApi\Endpoints;

class Uptimes extends KumaEndpoint
{
    public function get(?int $id = null): array
    {
        $endpoint = $id ?: '';

        return $this->jsonRequest($endpoint);
    }

    protected function rootEndpoint(): string
    {
        return 'uptimes';
    }
}
