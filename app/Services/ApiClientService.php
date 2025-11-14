<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

final class ApiClientService
{
    private string $baseUrl;

    private ?string $token = null;

//    public function __construct()
//    {
//        $this->baseUrl = config('services.auth.base_url');
//    }

    public function setToken(?string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function login(string $email, string $password)
    {
        $response = Http::withOptions([
            'verify' => false, // Disable SSL verification for local development
        ])->post('https://dashboard.test/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        if ($response->failed()) {
            throw new RuntimeException('Login failed: '.$response->body());
        }

        $data = $response->json();

//        $this->token = $data['token'];

        return $data;
    }
}
