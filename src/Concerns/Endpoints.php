<?php

namespace O21\KumaApi\Concerns;

use O21\KumaApi\Endpoints\Monitors;
use O21\KumaApi\Endpoints\Ping;

trait Endpoints
{
    public Monitors $monitors;
    public Ping $ping;

    protected function registerEndpoints(): void
    {
        $this->monitors = new Monitors($this);
        $this->ping = new Ping($this);
    }
}
