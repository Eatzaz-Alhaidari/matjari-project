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
                'title' => 'أحدث لابتوبات الألعاب - خصم 15%',
                'description' => 'احصل على أداء فائق مع أحدث لابتوبات الألعاب من ASUS و MSI. خصومات تصل إلى 15% لفترة محدودة.',
                'status' => 1, // active
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'budget' => 500.00,
                'clicks' => 150,
                'views' => 2500,
                'target_url' => 'https://example.com/gaming-laptops',
            ],
            [
                'title' => 'شحن مجاني لجميع قطع التجميع',
                'description' => 'قم بتجميع جهاز أحلامك الآن واحصل على شحن مجاني لكامل الصندوق عند شراء كرت شاشة ومعالج.',
                'status' => 1, // active
                'start_date' => now()->addDays(1),
                'end_date' => now()->addDays(15),
                'budget' => 300.00,
                'clicks' => 89,
                'views' => 1200,
                'target_url' => 'https://example.com/pc-builds',
            ],
            [
                'title' => 'كروت الشاشة RTX 40 Series',
                'description' => 'الجيل الجديد من كروت الشاشة NVIDIA GeForce RTX 40 متوفر الآن. ارتقِ بتجربة اللعب.',
                'status' => 0, // pending
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(25),
                'budget' => 250.00,
                'clicks' => 0,
                'views' => 0,
                'target_url' => 'https://example.com/rtx-cards',
            ],
            [
                'title' => 'عرض خاص على الشاشات المنحنية',
                'description' => 'شاشات سامسونج المنحنية للألعاب، دقة 4K ومعدل تحديث 144Hz، الآن بسعر التكلفة.',
                'status' => 0, // inactive -> pending
                'start_date' => now()->subDays(10),
                'end_date' => now()->subDays(1),
                'budget' => 400.00,
                'clicks' => 75,
                'views' => 1800,
                'target_url' => 'https://example.com/monitors',
            ],
            [
                'title' => 'اكسسوارات الجيمينج الاحترافية',
                'description' => 'لوحات مفاتيح ميكانيكية، سماعات محيطية، وماوسات احترافية. اكمل السيت اب الخاص بك.',
                'status' => 1, // active
                'start_date' => now(),
                'end_date' => now()->addDays(20),
                'budget' => 350.00,
                'clicks' => 200,
                'views' => 3200,
                'target_url' => 'https://example.com/accessories',
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
