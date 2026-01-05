<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;

class ReviewApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_approved_reviews_for_product()
    {
        // 1. Setup Data
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => '1234567890'
        ]);

        $store = Store::create([
            'name' => 'Test Store',
            'slug' => 'test-store',
            'user_id' => $user->id,
            'description' => 'Test Description'
        ]);

        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);

        $product = Product::create([
            'name' => 'Test Product',
            'brand' => 'Test Brand',
            'description' => 'Desc',
            'full_description' => 'Full Desc', // Added strictly
            'price' => 100.00,
            'stock' => 10,
            'status' => 'active',
            'store_id' => $store->id,
            'category_id' => $category->id
        ]);

        // Create one approved review and one pending
        Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Great!',
            'status' => 'approved'
        ]);

        Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => 1,
            'comment' => 'Bad (Pending)',
            'status' => 'pending'
        ]);

        // 2. Act
        $response = $this->getJson("/api/products/{$product->id}/reviews");

        // 3. Assert
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data.reviews') // Should only see the approved one
            ->assertJsonPath('data.reviews.0.rating', 5)
            ->assertJsonPath('data.reviews.0.comment', 'Great!')
            ->assertJsonPath('data.average_rating', 5)
            ->assertJsonPath('data.total_reviews', 1);
    }

    public function test_can_submit_review()
    {
        // 1. Setup Data
        $user = User::create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'phone' => '0987654321'
        ]);

        $store = Store::create([
            'name' => 'Test Store 2',
            'slug' => 'test-store-2',
            'user_id' => $user->id,
            'description' => 'Test Description 2'
        ]);

        $category = Category::create([
            'name' => 'Test Category 2',
            'slug' => 'test-category-2'
        ]);

        $product = Product::create([
            'name' => 'Test Product 2',
            'brand' => 'Test Brand',
            'description' => 'Desc',
            'full_description' => 'Full Desc',
            'price' => 100.00,
            'stock' => 10,
            'status' => 'active',
            'store_id' => $store->id,
            'category_id' => $category->id
        ]);

        // 2. Act
        $data = [
            'product_id' => $product->id,
            'rating' => 4,
            'comment' => 'Nice product',
            'user_id' => $user->id
        ];

        $response = $this->postJson('/api/reviews', $data);

        // 3. Assert
        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', 'pending');

        $this->assertDatabaseHas('reviews', [
            'product_id' => $product->id,
            'rating' => 4,
            'comment' => 'Nice product',
            'status' => 'pending'
        ]);
    }

    public function test_cannot_submit_invalid_review()
    {
        $response = $this->postJson('/api/reviews', [
            'rating' => 6 // Invalid
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['product_id', 'rating']);
    }
}
