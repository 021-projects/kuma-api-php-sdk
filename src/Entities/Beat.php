<?php

namespace O21\KumaApi\Entities;

use O21\ApiEntity\BaseEntity;

/**
 * Class Beat
 * @package O21\KumaApi\Entities
 *
 * @property int $id
 * @property int $monitorId
 * @property int $downCount
 * @property int $duration
 * @property bool $important
 * @property string $msg
 * @property int $ping
 * @property \O21\KumaApi\Enums\MonitorStatus $status
 * @property \Carbon\Carbon $time
 */
class Beat extends BaseEntity
{
}
