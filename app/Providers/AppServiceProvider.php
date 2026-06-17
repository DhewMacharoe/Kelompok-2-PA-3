<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use App\Models\Barbershop;

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

        try {
            View::composer('*', function ($view) {
                $activeBarbershop = null;

                if (app()->bound('currentTenantId')) {
                    $activeBarbershop = Barbershop::find(app('currentTenantId'));
                } else {
                    $activeBarbershop = Barbershop::where('is_active', true)->first();
                }

                $view->with('activeBarbershop', $activeBarbershop);
                $view->with('activeDesign', $activeBarbershop);
            });
        } catch (\Exception $e) {
            // Fallback in case tables are not migrated yet
            View::share('activeBarbershop', null);
            View::share('activeDesign', null);
        }
    }
}
