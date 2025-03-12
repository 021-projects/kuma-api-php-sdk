<?php

namespace O21\KumaApi\Enums;

enum MonitorStatus: int
{
    case UP = 1;
    case DOWN = 2;
    case PENDING = 3;
    case MAINTENANCE = 4;
}
