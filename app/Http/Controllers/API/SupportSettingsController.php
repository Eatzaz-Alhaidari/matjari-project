<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SupportSettingsController extends Controller
{
    /**
     * إرجاع إعدادات الدعم الفني لتطبيق الموبايل
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSettings()
    {
        // جلب جميع الإعدادات كـ مصفوفة (مفتاح => قيمة)
        $settings = Setting::pluck('value', 'key')->toArray();

        // تجميع روابط وقنوات التواصل والدعم الفني
        $supportSettings = [
            // نعطي الأولوية لمفتاح whatsapp إن وجد في القاعدة، وإلا نستخدم الرقم الافتراضي المطلوب
            'whatsapp' => $settings['whatsapp'] ?? $settings['support_whatsapp'] ?? $settings['support_phone'] ?? '778119982',
            
            // روابط قنوات التواصل المباشر الأخرى
            'facebook' => $settings['facebook'] ?? null,
            'twitter' => $settings['twitter'] ?? null,
            'instagram' => $settings['instagram'] ?? null,
            'telegram' => $settings['telegram'] ?? null,
            'support_email' => $settings['support_email'] ?? null,
        ];

        return response()->json([
            'success' => true,
            'message' => 'تم جلب البيانات بنجاح',
            'data' => $supportSettings
        ]);
    }
}
