<?php

namespace O21\KumaApi\Tests;

use Carbon\Carbon;
use O21\KumaApi\Entities\Heartbeat;
use O21\KumaApi\Entities\Monitor;
use O21\KumaApi\Enums\MonitorStatus;
use O21\KumaApi\Enums\MonitorType;

class MonitorsTest extends KumaTestCase
{
    protected ?Monitor $monitor = null;
    protected ?int $monitorId = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->auth();
    }

    public function testCreate(): void
    {
        $id = $this->kuma->monitors->create(
            MonitorType::HTTP,
            'name1',
            url: 'https://example.com'
        );

        $this->assertIsInt($id);

        $this->monitorId = $id;
    }

    public function testGetList(): void
    {
        $monitors = $this->kuma->monitors->list();

        $this->assertIsArray($monitors);
        $this->assertNotEmpty($monitors);

        $monitor = reset($monitors);

        $this->assertInstanceOf(Monitor::class, $monitor);
        $this->assertIsInt($monitor->id);
        $this->assertIsString($monitor->name);
        $this->assertIsString($monitor->url);
        $this->assertInstanceOf(MonitorType::class, $monitor->type);
        $this->assertIsInt($monitor->interval);
        $this->assertIsInt($monitor->retryInterval);
        $this->assertIsInt($monitor->resendInterval);
        $this->assertIsInt($monitor->maxretries);
        $this->assertIsBool($monitor->upsideDown);
        $this->assertIsArray($monitor->notificationIDList);
        $this->assertIsBool($monitor->expiryNotification);
        $this->assertIsBool($monitor->ignoreTls);
        $this->assertIsInt($monitor->maxredirects);
        $this->assertIsArray($monitor->acceptedStatuscodes);
        $this->assertIsString($monitor->method);
    }

    public function testGetById(): void
    {
        $this->assertMonitorIdSettled();

        $monitor = $this->kuma->monitors->get($this->monitorId);

        $this->assertInstanceOf(Monitor::class, $monitor);
        $this->assertEquals($this->monitorId, $monitor->id);

        $this->monitor = $monitor;
    }

    public function testBeats(): void
    {
        $this->assertMonitorSettled();

        sleep(2);

        $heartbeats = $this->kuma->monitors->beats($this->monitor->id);

        $this->assertIsArray($heartbeats);

        $hb = $heartbeats[0];

        $this->assertInstanceOf(Heartbeat::class, $hb);
        $this->assertIsInt($hb->id);
        $this->assertIsInt($hb->monitorId);
        $this->assertIsInt($hb->downCount);
        $this->assertIsInt($hb->duration);
        $this->assertIsBool($hb->important);
        $this->assertIsString($hb->msg);
        $this->assertIsInt($hb->ping);
        $this->assertInstanceOf(MonitorStatus::class, $hb->status);
        $this->assertInstanceOf(Carbon::class, $hb->time);
    }

    protected function assertMonitorSettled(): void
    {
        if (null === $this->monitor && null !== $this->monitorId) {
            $this->testGetById();
            return;
        }

        if (null === $this->monitor) {
            $this->testCreate();
            $this->testGetById();
        }
    }

    protected function assertMonitorIdSettled(): void
    {
        if (null === $this->monitorId) {
            $this->testCreate();
        }
    }
}
