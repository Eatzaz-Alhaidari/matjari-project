<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ElectronicsCategorySeederPost extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. مسح البيانات القديمة
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            [
                'name' => 'لابتوبات',
                'icon' => 'laptop',
                'banner' => 'banners/laptops.jpg',
                'subs' => ['ألترا بوك', 'جيمنج لابتوب', 'لابتوبات أعمال'],
                'brands' => ['Apple', 'HP', 'Dell', 'Asus', 'Lenovo', 'MSI', 'Microsoft']
            ],
            [
                'name' => 'شاشات',
                'icon' => 'tv',
                'banner' => 'banners/screens.jpg',
                'subs' => ['شاشات جيمنج', 'شاشات منحنية', 'شاشات 4K', 'شاشات مكاتب'],
                'brands' => ['Samsung', 'LG', 'Dell', 'BenQ', 'ViewSonic']
            ],
            [
                'name' => 'سماعات',
                'icon' => 'headphones',
                'banner' => 'banners/audio.jpg',
                'subs' => ['سماعات رأس (Over-ear)', 'سماعات بلوتوث', 'سماعات رياضية'],
                'brands' => ['Sony', 'Bose', 'JBL', 'Apple', 'Sennheiser']
            ],
            [
                'name' => 'طابعات',
                'icon' => 'print',
                'banner' => 'banners/printers.jpg',
                'subs' => ['طابعات ليزر', 'طابعات ملونة', 'طابعات حرارية'],
                'brands' => ['HP', 'Canon', 'Epson', 'Brother']
            ],
            [
                'name' => 'كاميرات',
                'icon' => 'camera',
                'banner' => 'banners/cameras.jpg',
                'subs' => ['كاميرات احترافية', 'كاميرات مراقبة', 'طائرات درون'],
                'brands' => ['Sony', 'Canon', 'Nikon', 'DJI']
            ],
            [
                'name' => 'معالجات (CPUs)',
                'icon' => 'microchip',
                'banner' => 'banners/cpus.jpg',
                'subs' => ['Intel Core', 'AMD Ryzen', 'معالجات سيرفرات'],
                'brands' => ['Intel', 'AMD']
            ],
            [
                'name' => 'ذاكرة عشوائية (RAM)',
                'icon' => 'memory',
                'banner' => 'banners/ram.jpg',
                'subs' => ['DDR4 للكمبيوتر', 'DDR5 للكمبيوتر', 'رامات لابتوب'],
                'brands' => ['Kingston', 'Corsair', 'Crucial', 'G.Skill']
            ],
            [
                'name' => 'فلاشات وتخزين',
                'icon' => 'usb-drive',
                'banner' => 'banners/storage.jpg',
                'subs' => ['فلاش ميموري', 'هاردسك خارجي', 'بطاقات ذاكرة (SD)'],
                'brands' => ['SanDisk', 'Samsung', 'WD', 'Kingston']
            ],
            [
                'name' => 'إكسسوارات',
                'icon' => 'keyboard',
                'banner' => 'banners/accessories.jpg',
                'subs' => ['ماوس وكيبورد', 'حقائب لابتوب', 'كابلات ومحولات'],
                'brands' => ['Logitech', 'Razer', 'HyperX', 'SteelSeries']
            ],
            [
                'name' => 'شبكات ومقويات',
                'icon' => 'router',
                'banner' => 'banners/networking.jpg',
                'subs' => ['راوترات Wi-Fi 6', 'مقويات إشارة', 'سويتشات شبكة'],
                'brands' => ['TP-Link', 'Linksys', 'Huawei', 'D-Link']
            ],
        ];

        foreach ($data as $item) {
            // إنشاء القسم الرئيسي
            $root = Category::create([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']) . '-' . rand(100, 999),
                'icon' => $item['icon'],
                // 'banner' => $item['banner'],
                'status' => 'active',
                'is_popular' => true,
                'parent_id' => null,
                'is_brand' => false
            ]);

            // إدراج الأقسام الفرعية
            foreach ($item['subs'] as $subName) {
                Category::create([
                    'name' => $subName,
                    'slug' => Str::slug($subName) . '-' . rand(100, 999),
                    'parent_id' => $root->id,
                    'status' => 'active',
                    'is_brand' => false
                ]);
            }

            // إدراج الماركات
            foreach ($item['brands'] as $brandName) {
                Category::create([
                    'name' => $brandName,
                    'slug' => Str::slug($brandName) . '-' . rand(100, 999),
                    'parent_id' => $root->id,
                    'status' => 'active',
                    'is_brand' => true,
                    'is_popular' => true
                ]);
            }
        }
    }
}
