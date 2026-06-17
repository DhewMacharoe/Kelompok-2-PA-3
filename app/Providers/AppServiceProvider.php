<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
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
            $activeBarbershop = Barbershop::where('is_active', true)->first();
            View::share('activeBarbershop', $activeBarbershop);
        } catch (\Exception $e) {
            // Biarkan null jika tabel belum ada atau error database lainnya
            View::share('activeBarbershop', null);
        }
    }
}
