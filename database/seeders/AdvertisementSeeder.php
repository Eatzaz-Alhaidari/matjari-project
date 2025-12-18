<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الحصول على بائع لديه متجر
        $vendor = User::role('vendor')->first();

        if (!$vendor || !$vendor->store) {
            // إنشاء بائع تجريبي إذا لم يوجد
            $vendor = User::factory()->create([
                'name' => 'بائع تجريبي',
                'email' => 'vendor@example.com',
            ]);
            $vendor->assignRole('vendor');

            // إنشاء متجر للبائع
            $vendor->store()->create([
                'name' => 'متجر تجريبي',
                'slug' => 'test-store',
                'description' => 'متجر تجريبي لاختبار النظام',
                'commercial_registration' => '123456789',
                'address' => 'الرياض، المملكة العربية السعودية',
            ]);
        }

        $advertisements = [
            [
                'title' => 'خصم 50% على جميع المنتجات الإلكترونية',
                'description' => 'عرض محدود الوقت! احصل على خصم 50% على جميع المنتجات الإلكترونية في متجرنا. لا تفوت هذه الفرصة الرائعة.',
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'budget' => 500.00,
                'clicks' => 150,
                'views' => 2500,
                'target_url' => 'https://example.com/electronics',
            ],
            [
                'title' => 'شحن مجاني للطلبات فوق 200 ريال',
                'description' => 'استمتع بشحن مجاني لجميع الطلبات التي تزيد قيمتها عن 200 ريال. عرض ساري حتى نهاية الشهر.',
                'status' => 'active',
                'start_date' => now()->addDays(1),
                'end_date' => now()->addDays(15),
                'budget' => 300.00,
                'clicks' => 89,
                'views' => 1200,
                'target_url' => 'https://example.com/free-shipping',
            ],
            [
                'title' => 'منتجات العناية بالبشرة بخصم 30%',
                'description' => 'اكتشف مجموعتنا الجديدة من منتجات العناية بالبشرة مع خصم 30% على جميع المنتجات.',
                'status' => 'pending',
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(25),
                'budget' => 250.00,
                'clicks' => 0,
                'views' => 0,
                'target_url' => 'https://example.com/skincare',
            ],
            [
                'title' => 'عرض خاص على الأحذية الرياضية',
                'description' => 'خصم يصل إلى 40% على جميع الأحذية الرياضية. اختر من أفضل الماركات العالمية.',
                'status' => 'inactive',
                'start_date' => now()->subDays(10),
                'end_date' => now()->subDays(1),
                'budget' => 400.00,
                'clicks' => 75,
                'views' => 1800,
                'target_url' => 'https://example.com/sports-shoes',
            ],
            [
                'title' => 'قسم الأطفال - خصومات تصل إلى 60%',
                'description' => 'كل ما يحتاجه طفلك بأسعار لا تُقاوم. خصومات تصل إلى 60% على جميع منتجات قسم الأطفال.',
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addDays(20),
                'budget' => 350.00,
                'clicks' => 200,
                'views' => 3200,
                'target_url' => 'https://example.com/kids-section',
            ],
        ];

        foreach ($advertisements as $data) {
            Advertisement::create([
                'store_id' => $vendor->store->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'budget' => $data['budget'],
                'clicks' => $data['clicks'],
                'views' => $data['views'],
                'target_url' => $data['target_url'],
            ]);
        }
    }
}
