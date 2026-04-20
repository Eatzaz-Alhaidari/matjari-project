<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    /**
     * Get all active products with filters.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::active()->with(['store', 'category', 'images']);

        // 1. فلترة حسب القسم (يدعم الأقسام الفرعية تلقائياً)
        if ($request->filled('category') || $request->filled('category_id')) {
            $category = null;
            if ($request->filled('category_id')) {
                $category = \App\Models\Category::find($request->category_id);
            } else {
                $category = \App\Models\Category::where('slug', $request->category)->first();
            }

            if ($category) {
                // جلب جميع معرفات الأقسام الفرعية بشكل متداخل
                $categoryIds = $this->getAllCategoryIds($category);
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // 2. فلترة حسب الماركة
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // 3. فلترة حسب المتجر
        if ($request->filled('store_id')) {
            $query->where('store_id', $request->store_id);
        }

        // 4. البحث النصي
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        $products = $query->latest()->limit(100)->get();

        return $this->sendResponse($products, 'تم جلب المنتجات بنجاح');
    }

    /**
     * جلب جميع معرفات الأقسام (القسم الحالي + الأبناء)
     */
    private function getAllCategoryIds($category)
    {
        $ids = [$category->id];
        foreach ($category->children as $child) {
            $ids = array_merge($ids, $this->getAllCategoryIds($child));
        }
        return $ids;
    }

    /**
     * Get top selling products.
     *
     * @return JsonResponse
     */
    public function topSelling(): JsonResponse
    {
        $products = Product::active()
            ->with(['images'])
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(10)
            ->get();

        return $this->sendResponse($products, 'تم جلب المنتجات الأكثر مبيعاً بنجاح');
    }

    /**
     * Get product detail.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $product = Product::with(['store', 'category', 'images', 'colors', 'sizes'])->find($id);

        if (!$product) {
            return $this->sendError('المنتج غير موجود', [], 404);
        }

        return $this->sendResponse($product, 'تم جلب تفاصيل المنتج بنجاح');
    }
}
