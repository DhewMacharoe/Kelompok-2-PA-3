<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Allow admin and super admin to bypass this check
            if ($user->hasRole('admin') || $user->hasRole('super_admin')) {
                return $next($request);
            }

            // Check if profile is incomplete
            if (empty($user->username) || empty($user->no_whatsapp)) {
                // Avoid infinite redirect loop
                $allowedRoutes = [
                    'set.username',
                    'set.username.post',
                    'logout',
                    'login.user',
                    'firebase.login',
                    'images.serve',
                ];

                if (!$request->routeIs($allowedRoutes)) {
                    return redirect()->route('set.username')
                        ->with('info', 'Silakan lengkapi profil Anda (Username dan No. WhatsApp) terlebih dahulu.');
                }
            }
        }

        return $next($request);
    }
}
