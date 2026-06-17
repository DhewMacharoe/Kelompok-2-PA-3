<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Resolve tenant dari parameter rute 'slug' (jika ada) dan simpan ke session
        $slug = $request->route('slug');
        if ($slug) {
            $barbershop = DB::table('barbershops')->where('slug', $slug)->first();
            if ($barbershop) {
                app()->instance('currentTenantId', $barbershop->id);
                session([
                    'current_barbershop_id' => $barbershop->id,
                    'current_barbershop_slug' => $barbershop->slug,
                    'current_barbershop_nama' => $barbershop->nama,
                ]);
            }
        }

        // 2. Load tenant dari session jika sudah tersimpan sebelumnya
        if (session()->has('current_barbershop_id')) {
            app()->instance('currentTenantId', session('current_barbershop_id'));
        }

        // 3. Admin yang login mengesampingkan context session (menggunakan barbershop_id milik admin)
        //    HANYA berlaku untuk rute admin, bukan halaman publik/pelanggan.
        $path = $request->path();
        $isAdminRoute = str_starts_with($path, 'admin') || str_starts_with($path, 'super-admin');
        if ($isAdminRoute && Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin') && $user->barbershop_id) {
                app()->instance('currentTenantId', $user->barbershop_id);
            }
        }

        // 4. Proteksi halaman pelanggan: paksa pilih barbershop jika berkunjung ke halaman operasional tanpa tenant context
        $isExcluded = $path === '/' || 
                      str_starts_with($path, 'admin') || 
                      str_starts_with($path, 'super-admin') || 
                      str_starts_with($path, 'login') || 
                      $path === 'firebase-login' || 
                      $path === 'logout' ||
                      str_starts_with($path, 'barbershop') ||
                      $path === 'test-firebase' ||
                      str_starts_with($path, 'images');

        if (!$isExcluded && !app()->bound('currentTenantId')) {
            return redirect('/')->with('info', 'Silakan pilih lokasi barbershop terlebih dahulu.');
        }

        return $next($request);
    }
}
