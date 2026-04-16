<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrateAdminDiscountsSeeder extends Seeder
{
    public function run(): void
    {
        $oldCoupons = DB::table('discount_coupons')->get();

        foreach ($oldCoupons as $coupon) {
            // التحقق مما إذا كان الكود موجوداً مسبقاً في الجدول الجديد
            $exists = DB::table('discounts')->where('code', $coupon->code)->exists();
            
            if (!$exists) {
                DB::table('discounts')->insert([
                    'store_id' => null,
                    'title' => 'كوبون: ' . $coupon->code,
                    'description' => 'تم نقله من نظام الكوبونات القديم',
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'min_order_amount' => $coupon->min_order_amount,
                    'start_date' => $coupon->created_at ?? now(),
                    'end_date' => $coupon->expiry_date,
                    'status' => $coupon->is_active ? 'active' : 'inactive',
                    'used_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
