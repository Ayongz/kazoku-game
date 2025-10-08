<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS when using ngrok or in production
        if (config('app.env') === 'local' && request()->headers->has('x-forwarded-proto')) {
            URL::forceScheme('https');
        }
        
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
