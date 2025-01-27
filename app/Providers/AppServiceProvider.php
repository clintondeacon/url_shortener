<?php

namespace App\Providers;

use App\Models\ShortenedUrl;
use App\Observers\ShortenedUrlObserver;
use App\Services\UrlShorteningService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
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

        RateLimiter::for('api', function ($request) {
            return Limit::perSecond(10)->by($request->ip());
        });
    }
}
