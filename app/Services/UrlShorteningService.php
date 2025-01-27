<?php

namespace App\Services;

use App\Models\ShortenedUrl;
use Illuminate\Support\Str;

class UrlShorteningService
{
    public function generateShortUrl(string $originalUrl): string
    {
        do {
            $shortUrl = substr(md5($originalUrl . time() . Str::random(5)), 0, 8);
        } while ($this->shortUrlExists($shortUrl)); // Ensure it's unique

        return $shortUrl;
    }

    /**
     * Check if the short URL already exists in the database.
     */
    private function shortUrlExists(string $shortUrl): bool
    {
        return ShortenedUrl::where('shortened_url', $shortUrl)->exists();
    }
}
