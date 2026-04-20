<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\JsonResponse;

class PaymentController extends BaseController
{
    /**
     * Get available payment methods.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $methods = [
            [
                'id' => 'cash',
                'name' => 'الدفع عند الاستلام',
                'icon' => 'cash-outline'
            ],
            [
                'id' => 'wallet',
                'name' => 'المحفظة الإلكترونية',
                'icon' => 'wallet-outline'
            ],
            [
                'id' => 'bank_transfer',
                'name' => 'تحويل بنكي',
                'icon' => 'card-outline'
            ]
        ];

        if ($this->floosakIsAvailable()) {
            $methods[] = [
                'id' => 'floosak_wallet',
                'name' => 'محفظة فلوسك',
                'icon' => 'wallet-outline',
            ];
        }

        return $this->sendResponse($methods, 'تم جلب طرق الدفع بنجاح');
    }

    private function floosakIsAvailable(): bool
    {
        return (bool) config('floosak.enabled')
            && filled(config('floosak.base_url'))
            && filled(config('floosak.merchant_phone'))
            && filled(config('floosak.merchant_password'))
            && is_numeric(config('floosak.source_wallet_id'))
            && (int) config('floosak.source_wallet_id') > 0;
    }
}
