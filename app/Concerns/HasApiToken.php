<?php

declare(strict_types=1);

namespace App\Concerns;

use Native\Mobile\Facades\SecureStorage;

trait HasApiToken
{
    protected function getApiToken(): ?string
    {
        return SecureStorage::get('api_token') ?? session('api_token');
    }

    protected function requireApiToken(): string
    {
        $token = $this->getApiToken();

        if (empty($token)) {
            $this->redirect(route('login'), navigate: true);
        }

        return $token;
    }
}
