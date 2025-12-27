<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'لابتوبات',
            'أجهزة كمبيوتر مكتبية',
            'شواحن',
            'فلاشات USB',
            'فارات (فأرة)',
            'كيبوردات',
            'طابعات',
            'سماعات',
            'شاشات كمبيوتر',
            'برمجيات وبرامج',
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat],
                [
                    'slug' => \Illuminate\Support\Str::slug($cat),
                    'status' => 'active'
                ]
            );
        }
    }
}
