<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PWAHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add PWA headers for manifest.json
        if ($request->is('manifest.json')) {
            $response->header('Content-Type', 'application/manifest+json; charset=utf-8');
            $response->header('Cache-Control', 'public, max-age=3600');
        }

        // Add headers for service worker
        if ($request->is('sw.js')) {
            $response->header('Content-Type', 'application/javascript; charset=utf-8');
            $response->header('Service-Worker-Allowed', '/');
            $response->header('Cache-Control', 'public, max-age=3600');
        }

        // Add headers for offline page
        if ($request->is('offline.html')) {
            $response->header('Content-Type', 'text/html; charset=utf-8');
            $response->header('Cache-Control', 'public, max-age=3600');
        }

        return $response;
    }
}
