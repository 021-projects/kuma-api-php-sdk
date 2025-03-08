<?php

namespace O21\KumaApi\Concerns;

use O21\KumaApi\Endpoints\Monitors;

trait Endpoints
{
    public Monitors $monitors;

    protected function registerEndpoints(): void
    {
        $this->monitors = new Monitors($this);
    }
}
