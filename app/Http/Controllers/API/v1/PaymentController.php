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

        return $this->sendResponse($methods, 'تم جلب طرق الدفع بنجاح');
    }
}
