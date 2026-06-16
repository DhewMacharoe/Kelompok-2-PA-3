<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\Design;

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
            $activeDesign = Design::where('is_active', true)->first();
            View::share('activeDesign', $activeDesign);
        } catch (\Exception $e) {
            // Biarkan null jika tabel belum ada atau error database lainnya
            View::share('activeDesign', null);
        }
    }
}
