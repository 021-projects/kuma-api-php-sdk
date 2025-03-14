<?php

namespace O21\KumaApi\Concerns;

use O21\KumaApi\Endpoints\Monitors;
use O21\KumaApi\Endpoints\Pings;
use O21\KumaApi\Endpoints\Uptimes;

trait Endpoints
{
    public Monitors $monitors;
    public Pings $pings;
    public Uptimes $uptimes;

    protected function registerEndpoints(): void
    {
        $this->monitors = new Monitors($this);
        $this->pings = new Pings($this);
        $this->uptimes = new Uptimes($this);
    }
}
