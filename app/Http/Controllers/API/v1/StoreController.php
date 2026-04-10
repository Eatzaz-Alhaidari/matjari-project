<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Store;
use App\Models\Advertisement;
use App\Models\Discount;
use Illuminate\Http\JsonResponse;

class StoreController extends BaseController
{
    /**
     * Get active stores.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $stores = Store::where('status', 'active')->get();
        return $this->sendResponse($stores, 'تم جلب المتاجر النشطة بنجاح');
    }

    /**
     * Get advertisements for a specific store.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function ads($id): JsonResponse
    {
        $ads = Advertisement::where('store_id', $id)
            ->where('status', 1) // Active
            ->latest()
            ->get();

        return $this->sendResponse($ads, 'تم جلب إعلانات المتجر بنجاح');
    }

    /**
     * Get discounts for a specific store.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function discounts($id): JsonResponse
    {
        $discounts = Discount::where('store_id', $id)
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->get();

        return $this->sendResponse($discounts, 'تم جلب خصومات المتجر بنجاح');
    }
}
