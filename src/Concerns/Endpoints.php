<?php

namespace O21\KumaApi\Concerns;

use O21\KumaApi\Endpoints\Monitors;
use O21\KumaApi\Endpoints\Ping;
use O21\KumaApi\Endpoints\Uptime;

trait Endpoints
{
    public Monitors $monitors;
    public Ping $ping;
    public Uptime $uptime;

    protected function registerEndpoints(): void
    {
        $this->monitors = new Monitors($this);
        $this->ping = new Ping($this);
        $this->uptime = new Uptime($this);
    }
}
