<?php

namespace O21\KumaApi\Enums;

enum MonitorStatus: string
{
    case UP = '<MonitorStatus.UP: 1>';
    case DOWN = '<MonitorStatus.DOWN: 2>';
    case PENDING = '<MonitorStatus.PENDING: 3>';
    case MAINTENANCE = '<MonitorStatus.MAINTENANCE: 4>';
}
