<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }

        // Share $activeDesign to all views dynamically (scoped per tenant because of global scope in Design model)
        View::composer('*', function ($view) {
            try {
                $activeDesign = \App\Models\Design::where('is_active', true)->first();
                $view->with('activeDesign', $activeDesign);
            } catch (\Exception $e) {
                $view->with('activeDesign', null);
            }
        });

        // Super Admin bypass: secara otomatis meloloskan semua pemeriksaan otorisasi
        Gate::before(function (User $user, string $ability) {
            if ($user->hasRole('super_admin')) {
                return true;
            }
        });

        // Gate untuk memvalidasi akses admin terhadap data operasional tenant
        Gate::define('manage-tenant-data', function (User $user, $model) {
            if ($user->hasRole('super_admin')) {
                return true;
            }

            if ($user->hasRole('admin') && isset($model->barbershop_id)) {
                return $user->barbershop_id === $model->barbershop_id;
            }

            return false;
        });
    }
}
