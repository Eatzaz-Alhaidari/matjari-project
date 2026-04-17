<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{
    /**
     * Get all active products.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = Product::active()
            ->with(['store', 'category'])
            ->latest()
            ->limit(20)
            ->get();

        return $this->sendResponse($products, 'تم جلب جميع المنتجات بنجاح');
    }

    /**
     * Get top selling products.
     *
     * @return JsonResponse
     */
    public function topSelling(): JsonResponse
    {
        $products = Product::active()
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(10)
            ->get();

        return $this->sendResponse($products, 'تم جلب المنتجات الأكثر مبيعاً بنجاح');
    }
}
