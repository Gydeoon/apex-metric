<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 1. WAJIB TAMBAHKAN LINE INI

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
        // 2. PAKSA SEMUA URL, FORM ACTION, DAN REDIRECT MENGGUNAKAN HTTPS DI PRODUCTION
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}