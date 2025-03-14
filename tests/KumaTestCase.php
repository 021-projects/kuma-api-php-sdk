<?php

namespace O21\KumaApi\Tests;

use O21\KumaApi\KumaApi;
use PHPUnit\Framework\TestCase;

class KumaTestCase extends TestCase
{
    protected KumaApi $kuma;

    protected function setUp(): void
    {
        $this->kuma = new KumaApi(env('KUMA_URL'));
    }

    protected function auth(): void
    {
        if ($this->kuma->getAccessToken()) {
            return;
        }

        $this->kuma->login(env('KUMA_USERNAME'), env('KUMA_PASSWORD'));
    }

    protected static function getAuthorizedKuma(): KumaApi
    {
        $kuma = new KumaApi(env('KUMA_URL'));
        $kuma->login(env('KUMA_USERNAME'), env('KUMA_PASSWORD'));
        return $kuma;
    }
}
