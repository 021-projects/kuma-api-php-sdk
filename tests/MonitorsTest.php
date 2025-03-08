<?php

namespace O21\KumaApi\Tests;

use O21\KumaApi\Enums\MonitorType;
use O21\KumaApi\KumaApi;
use PHPUnit\Framework\TestCase;

class MonitorsTest extends TestCase
{
    public function test_create(): void
    {
        $kuma = new KumaApi('http://127.0.0.1:3002');
        $kuma->login('admin', 'admin1');
        $kuma->monitors->create(MonitorType::HTTP, 'name', url: 'http://example.com');
    }
}
