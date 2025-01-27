<?php

namespace Tests\Unit;

use App\Models\ShortenedUrl;
use App\Services\UrlShorteningService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Faker\Factory as Faker;

class ShortenedUrlTest extends TestCase
{
    use RefreshDatabase;

    private UrlShorteningService $urlShorteningService;
    private $faker;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->urlShorteningService = new UrlShorteningService();
        $this->faker = Faker::create();
    }

    /**
     * Test that the URL shortening service generates unique short URLs.
     */
    public function test_generate_short_url()
    {

        for ($i = 0; $i < 10; $i++) {

            $originalUrl = $this->faker->url;

            $this->assertNotNull($this->urlShorteningService->generateShortUrl($originalUrl));

            // create twice to account for duplicates
            ShortenedUrl::firstOrCreate(['url' => $originalUrl]);
            ShortenedUrl::firstOrCreate(['url' => $originalUrl]);

        }

        $this->assertCount(10, ShortenedUrl::get()->toArray());

    }

    public function test_encode_and_decode_via_api(): void
    {
        $original_url = $this->faker->url;

        $encodeResponse = $this->postJson('/encode', [
            'url' => $original_url,
        ]);

        $shortened_url = Arr::get($encodeResponse,'data.shortened_url');

        $encodeResponse->assertStatus(200);
        $this->assertNotNull($shortened_url);
        $this->assertEquals(Arr::get($encodeResponse,'data.original_url'), $original_url);

        $decodeResponse1 = $this->postJson('/decode', [
            'url' => $shortened_url,
        ]);

        $decodeResponse1->assertStatus(200);
        $this->assertNotNull(Arr::get($decodeResponse1,'data.shortened_url'));
        $this->assertEquals(Arr::get($decodeResponse1,'data.original_url'), $original_url);

        $decodeResponse2 = $this->postJson('/decode', [
            'url' => Arr::get(parse_url($shortened_url),'path'),
        ]);

        $decodeResponse2->assertStatus(200);
        $this->assertNotNull(Arr::get($decodeResponse2,'data.shortened_url'));
        $this->assertEquals(Arr::get($decodeResponse2,'data.original_url'), $original_url);

        $this->assertEquals(Arr::get($decodeResponse1,'data.original_url'), Arr::get($decodeResponse2,'data.original_url'));
        $this->assertEquals(Arr::get($decodeResponse1,'data.shortened_url'), Arr::get($decodeResponse2,'data.shortened_url'));

    }

}
