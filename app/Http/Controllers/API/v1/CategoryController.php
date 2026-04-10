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
        $categories = Category::where('is_brand', false)->get();
        $brands = Category::where('is_brand', true)->get();

        return $this->sendResponse([
            'categories' => $categories,
            'brands' => $brands
        ], 'تم جلب التصنيفات والماركات بنجاح');
    }
}
