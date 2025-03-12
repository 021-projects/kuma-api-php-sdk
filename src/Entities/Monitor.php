<?php

namespace O21\KumaApi\Entities;

use O21\ApiEntity\BaseEntity;

/**
 * Class Monitor
 * @package O21\KumaApi\Entities
 *
 * @property int $id
 * @property string $name
 * @property \O21\KumaApi\Enums\MonitorType $type
 * @property string $pathName
 * @property string $url
 * @property bool $active
 * @property bool $forceInactive
 * @property bool $maintenance
 * @property bool $includeSensitiveData
 * @property string $description
 * @property int $interval
 * @property int $retryInterval
 * @property int $resendInterval
 * @property int $maxretries
 * @property bool $upsideDown
 * @property array $notificationIDList
 * @property bool $expiryNotification
 * @property bool $ignoreTls
 * @property int $maxredirects
 * @property array $acceptedStatuscodes
 * @property ?int $proxyId
 * @property string $method
 * @property string $httpBodyEncoding
 * @property string $body
 * @property array $headers
 * @property string $authMethod
 * @property string $tlsCert
 * @property string $tlsKey
 * @property string $tlsCa
 * @property string $basicAuthUser
 * @property string $basicAuthPass
 * @property string $authDomain
 * @property string $authWorkstation
 * @property string $oauthAuthMethod
 * @property string $oauthTokenUrl
 * @property string $oauthClientId
 * @property string $oauthClientSecret
 * @property string $oauthScopes
 * @property int $timeout
 * @property string $keyword
 * @property bool $invertKeyword
 * @property string $hostname
 * @property int $packetSize
 * @property int $port
 * @property string $dnsResolveServer
 * @property \O21\KumaApi\Enums\DnsResolveType $dnsResolveType
 * @property bool $dockerContainer
 * @property int $dockerHost
 * @property string $radiusUsername
 * @property string $radiusPassword
 * @property string $radiusSecret
 * @property string $radiusCalledStationId
 * @property string $radiusCallingStationId
 * @property string $game
 * @property bool $gamedigGivenPortOnly
 * @property string $jsonPath
 * @property string $expectedValue
 * @property string $databaseConnectionString
 * @property string $databaseQuery
 */
class Monitor extends BaseEntity
{
}
