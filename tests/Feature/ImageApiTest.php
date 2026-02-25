<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageApiTest extends TestCase
{
    public function test_image_proxy_returns_correct_headers_and_status()
    {
        Storage::fake('public');

        // Create a fake image
        $path = 'products/test-image.jpg';
        Storage::disk('public')->put($path, 'fake content');

        // Test the proxy route
        $response = $this->get('/api/image/products/test-image.jpg');

        $response->assertStatus(200);
        $response->assertHeader('Access-Control-Allow-Origin', '*');
        $response->assertHeader('Content-Type', 'image/jpeg');
    }

    public function test_image_proxy_returns_404_for_non_existent_file()
    {
        Storage::fake('public');

        $response = $this->get('/api/image/products/non-existent.jpg');

        $response->assertStatus(404);
    }
}
