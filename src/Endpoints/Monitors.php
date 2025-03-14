<?php

namespace O21\KumaApi\Endpoints;

use O21\KumaApi\Entities\Heartbeat;
use O21\KumaApi\Entities\Monitor;
use O21\KumaApi\Entities\MonitorDashboard;
use O21\KumaApi\Enums\DnsResolveType;
use O21\KumaApi\Enums\MonitorType;

class Monitors extends KumaEndpoint
{
    protected const MSG_DELETED = 'Deleted Successfully.';

    /**
     * @return Monitor[]
     */
    public function list(): array
    {
        $monitors = $this->jsonRequest()['monitors'] ?? [];
        return array_map(fn(array $monitor) => new Monitor($monitor), $monitors);
    }

    public function get(int $id): ?Monitor
    {
        $data = $this->jsonRequest((string)$id);
        return ! empty($data['id']) ? new Monitor($data) : null;
    }

    public function dashboard(int $id, int $heartbeatsHours = 1): ?MonitorDashboard
    {
        $data = $this->jsonRequest("/$id/dashboard", [
            'heartbeats_hours' => $heartbeatsHours,
        ]);

        return ! empty($data['monitor']) ? new MonitorDashboard($data) : null;
    }

    /**
     * @link https://uptime-kuma-api.readthedocs.io/en/latest/api.html#uptime_kuma_api.UptimeKumaApi.add_monitor
     */
    public function create(
        MonitorType $type,
        string $name,
        ?string $parent = null,
        ?string $url = null,
        ?string $description = null,
        ?int $interval = null,
        ?int $retryInterval = null,
        ?int $resendInterval = null,
        ?int $maxretries = null,
        ?bool $upsideDown = null,
        ?array $notificationIDList = null,
        ?bool $expiryNotification = null,
        ?bool $ignoreTls = null,
        ?int $maxredirects = null,
        ?array $accepted_statuscodes = ['200-299'],
        ?int $proxyId = null,
        ?string $method = null,
        ?string $httpBodyEncoding = null,
        ?string $body = null,
        ?array $headers = null,
        ?string $authMethod = null,
        ?string $tlsCert = null,
        ?string $tlsKey = null,
        ?string $tlsCa = null,
        ?string $basic_auth_user = null,
        ?string $basic_auth_pass = null,
        ?string $authDomain = null,
        ?string $authWorkstation = null,
        ?string $oauth_auth_method = null,
        ?string $oauth_token_url = null,
        ?string $oauth_client_id = null,
        ?string $oauth_client_secret = null,
        ?string $oauth_scopes = null,
        ?int $timeout = null,
        ?string $keyword = null,
        ?bool $invertKeyword = null,
        ?string $hostname = null,
        ?int $packetSize = null,
        ?int $port = null,
        ?string $dns_resolve_server = null,
        ?DnsResolveType $dns_resolve_type = null,
        ?string $mqttUsername = null,
        ?string $mqttPassword = null,
        ?string $mqttTopic = null,
        ?string $mqttSuccessMessage = null,
        ?string $databaseConnectionString = null,
        ?string $databaseQuery = null,
        ?string $docker_container = null,
        ?int $docker_host = null,
        ?string $radiusUsername = null,
        ?string $radiusPassword = null,
        ?string $radiusSecret = null,
        ?string $radiusCalledStationId = null,
        ?string $radiusCallingStationId = null,
        ?string $game = null,
        ?bool $gamedigGivenPortOnly = null,
        ?string $jsonPath = null,
        ?string $expectedValue = null,
        ?string $kafkaProducerBrokers = null,
        ?string $kafkaProducerTopic = null,
        ?string $kafkaProducerMessage = null,
        ?bool $kafkaProducerSsl = null,
        ?bool $kafkaProducerAllowAutoTopicCreation = null,
        ?array $kafkaProducerSaslOptions = null,
    ): ?int {
        $payload = array_filter(
            get_defined_vars(),
            fn($value) => $value !== null,
            ARRAY_FILTER_USE_BOTH
        );

        $payload['type'] = $type->value;

        if ($dns_resolve_type) {
            $payload['dns_resolve_type'] = $dns_resolve_type->value;
        }

        $data = $this->jsonRequest(
            params: $payload,
            method: 'POST'
        );

        return $data['monitorID'] ?? null;
    }

    public function delete(int $id): bool
    {
        $data = $this->jsonRequest((string)$id, method: 'DELETE');
        $msg = $data['msg'] ?? null;
        return $msg === self::MSG_DELETED;
    }

    /**
     * @param  int  $id
     * @param  int  $hours
     * @return \O21\KumaApi\Entities\Heartbeat[]|null
     */
    public function beats(int $id, int $hours = 1): ?array
    {
        $data = $this->formRequest("/$id/beats", compact('hours'));

        if (empty($data)) {
            return null;
        }

        return array_map(fn(array $beat) => new Heartbeat($beat), $data);
    }

    protected function rootEndpoint(): string
    {
        return '/monitors';
    }
}
