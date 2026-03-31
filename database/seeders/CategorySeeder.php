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
        // 1. تنظيف البيانات القديمة (اختياري، يفضل استخدامه لضمان بناء الشجرة من جديد)
        // \App\Models\Product::query()->update(['category_id' => null]);
        // Category::query()->delete();

        $tree = [
            'لابتوبات' => [
                'لابتوبات ألعاب (Gaming)', 
                'لابتوبات أعمال', 
                'لابتوبات للدراسة', 
                'أجهزة 2 في 1'
            ],
            'فلاشات USB' => [
                'فلاشات USB 3.0', 
                'فلاشات Type-C', 
                'فلاشات للايفون', 
                'سعة 128GB+'
            ],
            'فارات (فأرة)' => [
                'ماوس ألعاب', 
                'ماوس لاسلكي', 
                'ماوس بلوتوث', 
                'ماوس مريح'
            ],
            'كيبوردات' => [
                'كيبورد ميكانيكي', 
                'كيبورد ألعاب RGB', 
                'كيبورد لاسلكي', 
                'كيبورد عربي/إنجليزي'
            ],
            'طابعات' => [
                'طابعات ليزر', 
                'طابعات حبر', 
                'طابعات صور', 
                'طابعات الكل في واحد'
            ],
            'سماعات' => [
                'سماعات ألعاب', 
                'سماعات بلوتوث', 
                'سماعات سلكية', 
                'سماعات رياضية'
            ],
            'شاشات' => [
                'شاشات ألعاب (144Hz+)', 
                'شاشات 4K', 
                'شاشات منحنية', 
                'شاشات مكتبية'
            ],
            'برمجيات' => [
                'أنظمة ويندوز', 
                'برامج حماية', 
                'حزمة أوفيس', 
                'برامج تصميم'
            ],
            'شواحن' => [
                'شواحن لابتوب', 
                'شواحن هواتف سريعة', 
                'منصات شحن لاسلكي'
            ],
            'معالجات' => [
                'معالجات Intel Core', 
                'معالجات AMD Ryzen', 
                'معالجات سيرفرات'
            ],
        ];

        foreach ($tree as $mainCategoryName => $subCategories) {
            // إنشاء التصنيف الرئيسي
            $mainCategory = Category::updateOrCreate(
                ['name' => $mainCategoryName],
                [
                    'slug' => \Illuminate\Support\Str::slug($mainCategoryName),
                    'status' => 'active',
                    'parent_id' => null
                ]
            );

            foreach ($subCategories as $subName) {
                // إنشاء التصنيفات الفرعية
                Category::updateOrCreate(
                    ['name' => $subName, 'parent_id' => $mainCategory->id],
                    [
                        'slug' => \Illuminate\Support\Str::slug($subName),
                        'status' => 'active'
                    ]
                );
            }
        }
    }
}
