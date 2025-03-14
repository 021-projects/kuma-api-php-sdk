<?php

namespace O21\KumaApi\Entities;

use O21\ApiEntity\BaseEntity;

/**
 * @property \O21\KumaApi\Entities\Monitor $monitor
 * @property \O21\KumaApi\Entities\Heartbeat[] $heartbeats
 * @property \O21\KumaApi\Entities\Certificate $cert
 * @property float $avgResponseTime
 * @property array $uptimes
 */
class MonitorDashboard extends BaseEntity
{
}
