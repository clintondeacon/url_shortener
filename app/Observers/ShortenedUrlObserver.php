<?php

namespace App\Observers;

use App\Models\ShortenedUrl;
use App\Services\UrlShorteningService;

class ShortenedUrlObserver
{

    protected UrlShorteningService $urlShorteningService;

    public function __construct(UrlShorteningService $urlShorteningService)
    {
        $this->urlShorteningService = $urlShorteningService;
    }

    /**
     * Handle the ShortenedUrl "creating" event.
     */
    public function creating(ShortenedUrl $shortenedUrl): void
    {
        if (empty($shortenedUrl->shortened_url)) {
            $shortenedUrl->shortened_url = $this->urlShorteningService->generateShortUrl($shortenedUrl->url);
        }

    }
}
