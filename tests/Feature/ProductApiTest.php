<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_categories()
    {
        Category::create(['name' => 'Cat 1', 'slug' => 'cat-1', 'status' => 'active']);
        Category::create(['name' => 'Cat 2', 'slug' => 'cat-2', 'status' => 'active']);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(2, 'data');
    }

    public function test_can_list_active_products()
    {
        $user = User::create(['name' => 'U', 'email' => 'u@e.com', 'password' => 'p', 'phone' => '1']);
        $store = Store::create(['name' => 'S', 'slug' => 's', 'user_id' => $user->id]);
        $cat = Category::create(['name' => 'C', 'slug' => 'c']);

        Product::create([
            'name' => 'Prod 1',
            'brand' => 'B',
            'description' => 'D',
            'full_description' => 'FD',
            'price' => 10,
            'stock' => 5,
            'status' => 'active',
            'store_id' => $store->id,
            'category_id' => $cat->id
        ]);

        Product::create([
            'name' => 'Prod 2',
            'brand' => 'B',
            'description' => 'D',
            'full_description' => 'FD',
            'price' => 20,
            'stock' => 5,
            'status' => 'inactive', // Should not appear
            'store_id' => $store->id,
            'category_id' => $cat->id
        ]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data.data') // Only active product
            ->assertJsonPath('data.data.0.name', 'Prod 1');
    }

    public function test_can_show_product_details()
    {
        $user = User::create(['name' => 'U', 'email' => 'u@e.com', 'password' => 'p', 'phone' => '1']);
        $store = Store::create(['name' => 'S', 'slug' => 's', 'user_id' => $user->id]);
        $cat = Category::create(['name' => 'C', 'slug' => 'c']);

        $prod = Product::create([
            'name' => 'Prod Detail',
            'brand' => 'B',
            'description' => 'D',
            'full_description' => 'FD',
            'price' => 50,
            'stock' => 5,
            'status' => 'active',
            'store_id' => $store->id,
            'category_id' => $cat->id
        ]);

        $response = $this->getJson("/api/products/{$prod->id}");

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'Prod Detail');
    }

    public function test_can_sync_inventory_from_desktop()
    {
        $user = User::create(['name' => 'U', 'email' => 'u@e.com', 'password' => 'p', 'phone' => '1']);
        $store = Store::create(['name' => 'S', 'slug' => 's', 'user_id' => $user->id]);
        $cat = Category::create(['name' => 'C', 'slug' => 'c']);

        $prod = Product::create([
            'sku' => 'SKU123',
            'name' => 'Prod Sync',
            'brand' => 'B',
            'description' => 'D',
            'full_description' => 'FD',
            'price' => 30,
            'stock' => 10, // Initial stock
            'status' => 'active',
            'store_id' => $store->id,
            'category_id' => $cat->id
        ]);

        $syncData = [
            ['code' => 'SKU123', 'qty' => 50]
        ];

        $response = $this->postJson('/api/sync-inventory', $syncData);

        $response->assertStatus(200)
            ->assertJson(['status' => 'success', 'message' => 'تم تحديث المخزون بنجاح']);

        // Verify stock updated
        $prod->refresh();
        $this->assertEquals(50, $prod->stock);
    }
}
