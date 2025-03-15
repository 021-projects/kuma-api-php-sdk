<?php

namespace O21\KumaApi;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class KumaApi
{
    use Concerns\Auth;
    use Concerns\Endpoints;

    protected string $baseUri;
    protected Client $http;

    public function __construct(
        string $baseUri,
        protected ?string $accessToken = null,
    ) {
        $this->baseUri = $baseUri;
        $this->http = new Client([
            'base_uri' => $baseUri,
            'http_errors' => false,
        ]);

        $this->registerEndpoints();
    }

    public function formRequest(
        string $url,
        array $params = [],
        string $method = 'GET'
    ): mixed {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        if ($this->accessToken) {
            $headers['Authorization'] = "Bearer {$this->accessToken}";
        }

        $paramsKey = $method === 'GET' ? 'query' : 'form_params';

        $options = compact('headers');
        $options[$paramsKey] = $params;

        $response = $this->http->request($method, $url, $options);

        return $this->decodeResponse($response);
    }

    public function jsonRequest(
        string $url,
        array $params = [],
        string $method = 'GET'
    ): mixed {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        if ($this->accessToken) {
            $headers['Authorization'] = "Bearer {$this->accessToken}";
        }

        $paramsKey = $method === 'GET' ? 'query' : 'json';
        $options = compact('headers');
        $options[$paramsKey] = $params;

        $response = $this->http->request($method, $url, $options);

        return $this->decodeResponse($response);
    }

    protected function decodeResponse(Response $response): mixed
    {
        $json = @json_decode($response->getBody()->getContents(), true);

        if ($json) {
            return $json;
        }

        return $response->getBody()->getContents();
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
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
