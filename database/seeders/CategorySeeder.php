<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. تنظيف البيانات القديمة
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $structure = [
            'كمبيوتر ومكتب' => [
                'لابتوبات' => ['Apple', 'Dell', 'HP', 'Lenovo'],
                'كمبيوترات مكتبية' => ['HP', 'Dell', 'Lenovo'],
                'سرفرات' => ['Dell', 'HP'],
                'طابعات' => ['HP', 'Sony', 'Samsung'],
            ],
            'مكونات الكمبيوتر' => [
                'رامات' => ['Samsung', 'Kingston'],
                'هاردات' => ['Samsung', 'Western Digital'],
            ],
            'الشبكات والاتصالات' => [
                'مودمات' => ['TP-Link', 'Huawei'],
                'سوتشات' => ['Cisco', 'TP-Link'],
                'لوازم الشبكة' => [],
            ],
            'إلكترونيات استهلاكية' => [
                'كاميرات' => ['Sony', 'Samsung', 'LG'],
                'سماعات' => ['Apple', 'Sony'],
            ],
            'ملحقات وأدوات' => [
                'فلاشات' => ['Samsung', 'SanDisk'],
                'لوحة تحكم' => [],
                'إكسسوارات إلكترونية' => [],
            ],
        ];

        foreach ($structure as $rootName => $subCategories) {
            $root = Category::create([
                'name' => $rootName,
                'slug' => Str::slug($rootName, '-', 'ar') ?: Str::random(8),
                'status' => 'active',
                'parent_id' => null
            ]);

            foreach ($subCategories as $subName => $brands) {
                $sub = Category::create([
                    'name' => $subName,
                    'slug' => Str::slug($subName, '-', 'ar') ?: Str::random(8),
                    'status' => 'active',
                    'parent_id' => $root->id
                ]);

                foreach ($brands as $brandName) {
                    Category::create([
                        'name' => $brandName,
                        'slug' => Str::slug($sub->name . '-' . $brandName),
                        'status' => 'active',
                        'parent_id' => $sub->id,
                        'is_brand' => true
                    ]);
                }
            }
        }
    }
}
