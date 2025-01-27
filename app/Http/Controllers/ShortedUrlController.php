<?php

namespace App\Http\Controllers;

use App\Http\Requests\DecodeRequest;
use App\Http\Requests\EncodeRequest;
use App\Http\Resources\ShortenedUrlResource;
use App\Models\ShortenedUrl;

class ShortedUrlController extends Controller
{

    /**
     * /encode
     *
     * Encode a URL into a shortened version.
     *
     * This endpoint takes a long URL and returns a shortened version.
     *
     * @bodyParam url string required The original URL to be shortened. Example: https://example.com
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "id": 1,
     *     "original_url": "https://example.com",
     *     "shortened_url": "abc123",
     *   }
     * }
     */
    public function encode(EncodeRequest $request): \Illuminate\Http\JsonResponse
    {
        $shortenedUrl = ShortenedUrl::firstOrCreate(['url' => $request->url]);

        return response()->json([
            'success' => true,
            'data' => new ShortenedUrlResource($shortenedUrl),
        ]);

    }

    /**
     * /decode
     *
     * Decode a shortened URL back to its original version.
     *
     * This endpoint takes a shortened URL and returns the original URL.
     *
     * @bodyParam url string required The shortened URL to be decoded. Example: abc123
     *
     * @response 200 {
     *   "success": true,
     *   "shortened_url": "abc123",
     *   "data": {
     *     "id": 1,
     *     "original_url": "https://example.com",
     *     "shortened_url": "abc123",
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "shortened_url": "abc123",
     *   "message": "Shortened URL could not be found."
     * }
     */
    public function decode(DecodeRequest $request): \Illuminate\Http\JsonResponse
    {
        // Fix the url if the user is potentially passing the full url and not just the path
        $url = ltrim(str_replace(config('app.url') . '/', '', $request->url), '/');

        $shortenedUrl = ShortenedUrl::where(['shortened_url' => $url])->first();

        if($shortenedUrl) {

            return response()->json([
                'success' => true,
                'shortened_url' => $request->url,
                'data' => new ShortenedUrlResource($shortenedUrl),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'shortened_url' => $request->url,
                'message' => 'Shortened URL could not be found.',
            ], 404);
        }

    }

}
