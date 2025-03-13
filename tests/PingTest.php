<?php

namespace O21\KumaApi\Tests;

use O21\KumaApi\Endpoints\Ping;

class PingTest extends KumaTestCase
{
    protected Ping $endpoint;

    protected function setUp(): void
    {
        parent::setUp();

        $this->auth();
        $this->endpoint = $this->kuma->ping;
    }

    public function testAvgList(): void
    {
        $pings = $this->endpoint->avg();

        $this->assertIsArray($pings);
        $this->assertNotEmpty($pings);

        $monitors = $this->kuma->monitors->list();

        $this->assertSameSize($monitors, $pings);
    }

    public function testAvgById(): void
    {
        $monitors = $this->kuma->monitors->list();
        $monitor = reset($monitors);

        $ping = $this->endpoint->avg($monitor->id);

        $this->assertIsInt($ping);
    }
}
