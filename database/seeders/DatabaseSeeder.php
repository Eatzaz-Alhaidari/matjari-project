<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       // استدعاء الـ Seeder الخاص بنا هنا
        $this->call([
            RolesAndPermissionsSeeder::class,
            CategorySeeder::class,
            AdvertisementSeeder::class,
            DiscountSeeder::class,
            // يمكنكِ إضافة Seeders أخرى هنا لاحقاً لبيانات تجريبية للمنتجات، المتاجر، إلخ.
        ]);
    }
}
