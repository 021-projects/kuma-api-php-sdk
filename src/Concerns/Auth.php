<?php

namespace O21\KumaApi\Concerns;

trait Auth
{
    public function login(
        string $username,
        string $password
    ): ?string {
        $data = $this->formRequest(
            '/login/access-token/',
            compact('username', 'password'),
            'POST'
        );

        if (isset($data['access_token'])) {
            $this->accessToken = $data['access_token'];
        }

        return $this->accessToken;
    }
}
