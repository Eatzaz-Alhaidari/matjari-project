<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends BaseController
{
    /**
     * Get all categories and brands.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // جلب الأقسام الرئيسية (التي ليس لها أب) مع تحميل أبنائها وماركاتها
        $categories = Category::whereNull('parent_id')
            ->where('is_brand', false)
            ->with(['children', 'brands']) // Simplified: removed nested closures
            ->get();

        // جلب الماركات العامة (اختياري، إذا كنت تريد عرض ماركات غير مرتبطة بقسم معين)
        $standaloneBrands = Category::where('is_brand', true)
            ->whereNull('parent_id')
            ->get();

        return $this->sendResponse([
            'categories' => $categories,
            'brands' => $standaloneBrands
        ], 'تم جلب التصنيفات والماركات بنجاح بنظام الشجرة');
    }
}
