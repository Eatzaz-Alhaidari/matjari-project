<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Advertisement;
use Illuminate\Http\JsonResponse;

class AdController extends BaseController
{
    /**
     * Get active admin advertisements.
     *
     * @return JsonResponse
     */
    public function adminAds(): JsonResponse
    {
        $ads = Advertisement::where('is_admin', true)
            ->where('status', 1) // Active
            ->latest()
            ->get();

        return $this->sendResponse($ads, 'تم جلب إعلانات الإدمن بنجاح');
    }
}
