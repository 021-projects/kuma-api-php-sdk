<?php

namespace O21\KumaApi\Tests;

use Carbon\Carbon;
use O21\KumaApi\Endpoints\Monitors;
use O21\KumaApi\Entities\Certificate;
use O21\KumaApi\Entities\CertificateInfo;
use O21\KumaApi\Entities\CertificateIssuer;
use O21\KumaApi\Entities\CertificateSubject;
use O21\KumaApi\Entities\Heartbeat;
use O21\KumaApi\Entities\Monitor;
use O21\KumaApi\Entities\MonitorDashboard;
use O21\KumaApi\Enums\MonitorStatus;
use O21\KumaApi\Enums\MonitorType;

class MonitorsTest extends KumaTestCase
{
    public static ?int $_monitorId = null;

    protected ?Monitor $monitor = null;
    protected ?int $monitorId = null;
    protected Monitors $endpoint;

    protected function setUp(): void
    {
        parent::setUp();

        $this->auth();
        $this->endpoint ??= $this->kuma->monitors;
        $this->monitorId = self::$_monitorId;
    }

    public static function tearDownAfterClass(): void
    {
        if (null !== self::$_monitorId) {
            self::getAuthorizedKuma()
                ->monitors
                ->delete(self::$_monitorId);
        }
    }

    public function testCreate(): void
    {
        $id = $this->endpoint->create(
            MonitorType::HTTP,
            'name1',
            url: 'https://example.com'
        );

        $this->assertIsInt($id);

        $this->monitorId = $id;
        self::$_monitorId = $id;
    }

    public function testGetList(): void
    {
        $monitors = $this->endpoint->list();

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

    public function testDelete(): void
    {
        $this->assertMonitorIdSettled();

        $success = $this->endpoint->delete($this->monitorId);
        $this->assertTrue($success);

        $m = $this->endpoint->get($this->monitorId);
        $this->assertNull($m);

        $this->monitorId = null;
        self::$_monitorId = null;
    }

    public function testGetById(): void
    {
        $this->assertMonitorIdSettled();

        $monitor = $this->endpoint->get($this->monitorId);

        $this->assertInstanceOf(Monitor::class, $monitor);
        $this->assertEquals($this->monitorId, $monitor->id);

        $this->monitor = $monitor;
    }

    public function testDashboard(): void
    {
        $this->assertMonitorSettled();

        sleep(2);

        $dashboard = $this->endpoint->dashboard($this->monitor->id);

        $this->assertInstanceOf(MonitorDashboard::class, $dashboard);
        $this->assertInstanceOf(Monitor::class, $dashboard->monitor);
        $this->assertIsArray($dashboard->heartbeats);
        $this->assertInstanceOf(Heartbeat::class, reset($dashboard->heartbeats));
        $this->assertIsArray($dashboard->uptimes);
        $this->assertArrayHasKey('24', $dashboard->uptimes);
        $this->assertArrayHasKey('720', $dashboard->uptimes);
        $this->assertIsFloat($dashboard->avgResponseTime);
        $this->assertInstanceOf(Certificate::class, $dashboard->cert);
        $this->assertTrue($dashboard->cert->valid);
        $this->assertInstanceOf(CertificateInfo::class, $dashboard->cert->certInfo);
        $this->assertInstanceOf(CertificateIssuer::class, $dashboard->cert->certInfo->issuer);
        $this->assertIsString($dashboard->cert->certInfo->issuer->CN);
        $this->assertIsString($dashboard->cert->certInfo->issuer->O);
        $this->assertIsString($dashboard->cert->certInfo->issuer->C);
        $this->assertInstanceOf(CertificateSubject::class, $dashboard->cert->certInfo->subject);
        $this->assertIsString($dashboard->cert->certInfo->subject->CN);
        $this->assertIsString($dashboard->cert->certInfo->subject->O);
        $this->assertIsString($dashboard->cert->certInfo->subject->C);
    }

    public function testBeats(): void
    {
        $this->assertMonitorSettled();

        sleep(2);

        $heartbeats = $this->endpoint->beats($this->monitor->id);

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
