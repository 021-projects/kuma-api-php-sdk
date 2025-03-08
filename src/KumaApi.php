<?php

namespace O21\KumaApi;

use GuzzleHttp\Client;

class KumaApi
{
    use Concerns\Auth;
    use Concerns\Endpoints;

    protected Client $http;

    public function __construct(
        string $baseUrl,
        protected ?string $accessToken = null,
    ) {
        $this->http = new Client([
            'base_uri' => $baseUrl,
        ]);

        $this->registerEndpoints();
    }

    public function formRequest(
        string $url,
        array $params = [],
        string $method = 'GET'
    ): ?array {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        if ($this->accessToken) {
            $headers['Authorization'] = "Bearer {$this->accessToken}";
        }

        $response = $this->http->request($method, $url, [
            'headers' => $headers,
            'form_params' => $params,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function jsonRequest(
        string $url,
        array $params = [],
        string $method = 'GET'
    ): ?array {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        if ($this->accessToken) {
            $headers['Authorization'] = "Bearer {$this->accessToken}";
        }

        $response = $this->http->request($method, $url, [
            'headers' => $headers,
            'json' => $params,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken(?string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }
}
