<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

final class ApiClientService
{
    private string $baseUrl;

    private ?string $token = null;

    public function __construct()
    {
        $this->baseUrl = config('services.dashboard.url');
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function login(string $email, string $password): mixed
    {
        $response = Http::withOptions([
            'verify' => false, // Disable SSL verification for local development
        ])->post("{$this->baseUrl}/login", [
            'email' => $email,
            'password' => $password,
        ]);

        if ($response->failed()) {
            throw new RuntimeException('Login failed: '.$response->body());
        }

        return $response->json();
    }

    public function logout(): bool
    {
        if (! $this->token) {
            throw new RuntimeException('No token set to logout.');
        }

        $response = Http::withOptions([
            'verify' => false,
        ])->withToken($this->token)
            ->post("{$this->baseUrl}/logout");

        if ($response->failed()) {
            throw new RuntimeException('Logout failed: '.$response->body());
        }

        $this->token = null;

        return true;
    }

    public function getDealerships(): array
    {
        if (! $this->token) {
            throw new RuntimeException('No token set for API request.');
        }

        $response = Http::withOptions([
            'verify' => false,
        ])->withToken($this->token)
            ->get("{$this->baseUrl}/dealerships");

        if ($response->failed()) {
            throw new RuntimeException('Failed to fetch dealerships: '.$response->body());
        }

        return $response->json('dealerships', []);
    }

    public function getStores(string $dealershipId): array
    {
        if (! $this->token) {
            throw new RuntimeException('No token set for API request.');
        }

        $response = Http::withOptions([
            'verify' => false,
        ])->withToken($this->token)
            ->get("{$this->baseUrl}/stores", [
                'dealership_id' => $dealershipId,
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Failed to fetch stores: '.$response->body());
        }

        return $response->json('stores', []);
    }

    public function getStore(string $dealershipId, string $storeId): array
    {
        if (! $this->token) {
            throw new RuntimeException('No token set for API request.');
        }

        $response = Http::withOptions([
            'verify' => false,
        ])->withToken($this->token)
            ->get("{$this->baseUrl}/store", [
                'dealership_id' => $dealershipId,
                'store_id' => $storeId,
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Failed to fetch store: '.$response->body());
        }

        return $response->json('store', []);
    }
}
