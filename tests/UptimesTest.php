<?php

namespace O21\KumaApi\Tests;

use O21\KumaApi\Endpoints\Uptimes;

class UptimesTest extends KumaTestCase
{
    protected Uptimes $endpoint;

    protected function setUp(): void
    {
        parent::setUp();

        $this->auth();
        $this->endpoint = $this->kuma->uptimes;
    }

    public function testUptimeList(): void
    {
        $uptimes = $this->endpoint->get();

        $this->assertIsArray($uptimes);
        $this->assertNotEmpty($uptimes);

        $monitors = $this->kuma->monitors->list();

        $this->assertSameSize($monitors, $uptimes);
    }

    public function testUptimeById(): void
    {
        $monitors = $this->kuma->monitors->list();
        $monitor = reset($monitors);

        $uptime = $this->endpoint->get($monitor->id);

        $this->assertIsArray($uptime);
        $this->assertNotEmpty($uptime);

        $this->assertArrayHasKey('24', $uptime);
        $this->assertArrayHasKey('720', $uptime);
    }
}
