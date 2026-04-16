<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Discount;
use Illuminate\Http\JsonResponse;

class DiscountController extends BaseController
{
    /**
     * Get all active discounts (Admin + Vendor).
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $discounts = Discount::where('status', 'active')
            ->where('end_date', '>=', now())
            ->get();

        return $this->sendResponse($discounts, 'تم جلب جميع الخصومات النشطة بنجاح');
    }

    /**
     * Get admin discounts (store_id is null or 0).
     *
     * @return JsonResponse
     */
    public function adminDiscounts(): JsonResponse
    {
        $discounts = Discount::where(function ($query) {
                $query->whereNull('store_id')
                    ->orWhere('store_id', 0);
            })
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->get();

        return $this->sendResponse($discounts, 'تم جلب خصومات الإدمن بنجاح');
    }
}
