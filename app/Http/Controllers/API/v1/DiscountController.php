<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Discount;
use Illuminate\Http\JsonResponse;

class DiscountController extends BaseController
{
    /**
     * Get admin discounts (store_id is null).
     *
     * @return JsonResponse
     */
    public function adminDiscounts(): JsonResponse
    {
        $discounts = Discount::whereNull('store_id')
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->get();

        return $this->sendResponse($discounts, 'تم جلب خصومات الإدمن بنجاح');
    }
}
