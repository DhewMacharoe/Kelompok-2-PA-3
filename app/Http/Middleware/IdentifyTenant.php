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
        $path = $request->path();

        // 1. Definisikan halaman-halaman yang dikecualikan dari pemaksaan tenant context
        $isExcluded = $path === '/' || 
                      str_starts_with($path, 'admin') || 
                      str_starts_with($path, 'super-admin') || 
                      str_starts_with($path, 'login') || 
                      $path === 'firebase-login' || 
                      $path === 'logout' ||
                      str_starts_with($path, 'barbershop') ||
                      $path === 'test-firebase' ||
                      str_starts_with($path, 'images');

        // 2. Resolve tenant dari parameter rute 'slug' (jika ada) dan simpan ke session
        $slug = $request->route('slug');
        if ($slug) {
            $barbershop = DB::table('barbershops')
                ->where('slug', $slug)
                ->orWhere('slug', $slug . '-barbershop')
                ->first();
            if ($barbershop) {
                app()->instance('currentTenantId', $barbershop->id);
                session([
                    'current_barbershop_id' => $barbershop->id,
                    'current_barbershop_slug' => $barbershop->slug,
                    'current_barbershop_nama' => $barbershop->nama,
                ]);
            }
        }

        // 3. Load tenant dari session jika sudah tersimpan sebelumnya (hanya jika bukan halaman yang dikecualikan)
        if (!$isExcluded && !app()->bound('currentTenantId') && session()->has('current_barbershop_id')) {
            app()->instance('currentTenantId', session('current_barbershop_id'));
        }

        // 4. Admin yang login mengesampingkan context session (menggunakan barbershop_id milik admin)
        //    Super Admin yang login menggunakan context session yang aktif saat mengakses rute admin.
        //    HANYA berlaku untuk rute admin, bukan halaman publik/pelanggan.
        $isAdminRoute = str_starts_with($path, 'admin') || str_starts_with($path, 'super-admin');
        if ($isAdminRoute && Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin') && $user->barbershop_id) {
                app()->instance('currentTenantId', $user->barbershop_id);
            } elseif ($user->hasRole('super_admin') && session()->has('current_barbershop_id')) {
                app()->instance('currentTenantId', session('current_barbershop_id'));
            }
        }

        // 5. Set default parameter URL jika tenant terikat ke container
        if (app()->bound('currentTenantId')) {
            $activeSlug = session('current_barbershop_slug');
            if ($activeSlug) {
                \Illuminate\Support\Facades\URL::defaults([
                    'slug' => $activeSlug
                ]);
            }
        }

        // 6. Hapus parameter slug dari objek rute agar tidak dikirim ke fungsi controller
        if ($request->route() && $request->route()->hasParameter('slug')) {
            $request->route()->forgetParameter('slug');
        }

        // 7. Proteksi halaman pelanggan: paksa pilih barbershop jika berkunjung ke halaman operasional tanpa tenant context
        if (!$isExcluded && !app()->bound('currentTenantId')) {
            return redirect('/')->with('info', 'Silakan pilih lokasi barbershop terlebih dahulu.');
        }

        return $next($request);
    }
}
