<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GeminiStreamService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(GeminiStreamService::class, function ($app) {
            return new GeminiStreamService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
