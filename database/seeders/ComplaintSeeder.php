<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        // If no user exists, create a dummy one just for this test
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'عميل تجريبي',
                'email' => 'client@example.com',
            ]);
        }

        $complaints = [
            [
                'subject' => 'تأخير في استلام الطلب',
                'message' => 'لقد قمت بطلب المنتج منذ أسبوع ولم يصلني حتى الآن. أرجو التحقق من الأمر.',
                'status' => 'open',
            ],
            [
                'subject' => 'المنتج غير مطابق للمواصفات',
                'message' => 'وصلني المنتج بلون مختلف عن الذي طلبته في الموقع. أريد استرجاع المبلغ أو استبدال المنتج.',
                'status' => 'in_progress',
            ],
            [
                'subject' => 'مشكلة في الدفع الإلكتروني',
                'message' => 'حاولت الدفع ببطاقتي الائتمانية ولكن النظام يرفض العملية دون سبب واضح.',
                'status' => 'closed',
            ],
            [
                'subject' => 'شكوى بخصوص التغليف',
                'message' => 'تغليف المنتج كان سيئاً جداً وتعرض المنتج لخدوش أثناء الشحن.',
                'status' => 'open',
            ],
            [
                'subject' => 'استفسار عن الضمان',
                'message' => 'هل يشمل الضمان سوء الاستخدام أم فقط العيوب المصنعية؟',
                'status' => 'closed',
            ],
        ];

        foreach ($complaints as $data) {
            Complaint::create([
                'user_id' => $user->id,
                'order_id' => null, // Optional for now
                'subject' => $data['subject'],
                'message' => $data['message'],
                'status' => $data['status'],
            ]);
        }
    }
}
