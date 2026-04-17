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
        $ads = Advertisement::where('status', 1) // Active
            ->with('store:id,name,logo_path')
            ->latest()
            ->get();

        return $this->sendResponse($ads, 'تم جلب إعلانات الإدمن بنجاح');
    }
}
