<?php

namespace App\Providers;

use App\Models\ShortenedUrl;
use App\Observers\ShortenedUrlObserver;
use App\Services\UrlShorteningService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UrlShorteningService::class, function ($app) {
            return new UrlShorteningService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ShortenedUrl::observe(ShortenedUrlObserver::class);
    }
}
