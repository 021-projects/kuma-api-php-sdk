<?php

namespace O21\KumaApi\Tests;

use O21\KumaApi\Endpoints\Pings;

class PingsTest extends KumaTestCase
{
    protected Pings $endpoint;

    protected function setUp(): void
    {
        parent::setUp();

        $this->auth();
        $this->endpoint = $this->kuma->pings;
    }

    public function testGetList(): void
    {
        $pings = $this->endpoint->get();

        $this->assertIsArray($pings);
        $this->assertNotEmpty($pings);

        $monitors = $this->kuma->monitors->list();

        $this->assertSameSize($monitors, $pings);
    }

    public function testGetById(): void
    {
        $monitors = $this->kuma->monitors->list();
        $monitor = reset($monitors);

        $ping = $this->endpoint->get($monitor->id);

        $this->assertIsInt($ping);
    }
}
