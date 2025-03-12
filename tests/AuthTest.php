<?php

namespace O21\KumaApi\Tests;

use O21\KumaApi\KumaApi;

class AuthTest extends KumaTestCase
{
    public function testLogin(): void
    {
        $this->auth();

        $this->assertNotNull($this->kuma->getAccessToken());
    }

    public function testLoginWithToken(): void
    {
        $this->auth();

        $token = $this->kuma->getAccessToken();

        $newKuma = new KumaApi($this->kuma->getBaseUri());

        $this->assertNull($newKuma->getAccessToken());

        $newKuma->setAccessToken($token);

        $this->assertNotNull($newKuma->monitors->list());
    }
}
