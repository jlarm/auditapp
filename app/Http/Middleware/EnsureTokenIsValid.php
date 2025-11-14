<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Native\Mobile\Facades\SecureStorage;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check SecureStorage first (for native app), fallback to session (for web/dev)
        $token = SecureStorage::get('api_token') ?? session('api_token');

        if (!$token) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
