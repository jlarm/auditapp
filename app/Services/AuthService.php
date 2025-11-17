<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

final class AuthService
{
    private string $baseUrl;

    private string $token = '';

    public function __construct()
    {
        $this->baseUrl = config('services.auth.base_url');
    }

    public function testResponse(string $token)
    {
        return Http::get('{https://dashboard/api/test')->json();
    }
}
