<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info('No users or products found, skipping review seeding.');
            return;
        }

        foreach ($products as $product) {
            // Add 0-3 reviews per product
            $reviewCount = rand(0, 3);

            for ($i = 0; $i < $reviewCount; $i++) {
                Review::create([
                    'user_id' => $users->random()->id,
                    'product_id' => $product->id,
                    'rating' => rand(1, 5),
                    'comment' => $this->getRandomComment(),
                    'status' => ['pending', 'approved', 'rejected'][rand(0, 2)],
                ]);
            }
        }
    }

    private function getRandomComment()
    {
        $comments = [
            'منتج رائع جداً، أنصح به!',
            'الجودة مقبولة ولكن السعر مرتفع قليلاً.',
            'التوصيل كان سريعاً والمنتج كما في الوصف.',
            'لم يعجبني المنتج كثيراً.',
            'ممتاز!',
            'سيء جداً، لا أنصح به.',
            'جيد نوعاً ما.',
        ];

        return $comments[rand(0, count($comments) - 1)];
    }
}
