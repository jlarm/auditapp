<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Native\Mobile\Facades\SecureStorage;
use Symfony\Component\HttpFoundation\Response;

final class EnsureTokenIsValid
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check SecureStorage first (for native app), fallback to session (for web/dev)
        $secureStorageToken = SecureStorage::get('api_token');
        $sessionToken = session('api_token');
        $token = $secureStorageToken ?? $sessionToken;

        logger()->info('Token check', [
            'secure_storage_token' => $secureStorageToken,
            'secure_storage_type' => gettype($secureStorageToken),
            'session_token' => $sessionToken,
            'session_type' => gettype($sessionToken),
            'final_token' => $token,
            'path' => $request->path(),
            'is_empty' => empty($token),
        ]);

        if (empty($token)) {
            logger()->info('Token validation failed - redirecting to login');

            return redirect()->route('login');
        }

        logger()->info('Token validation passed - proceeding to route');

        return $next($request);
    }
}
