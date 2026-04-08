<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductManagementController extends Controller
{
    /**
     * API لبطاقة: إدارة المنتجات (جميع منتجات المنصة)
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->get('status');
        $query = Product::with(['store', 'category']);

        if ($status) {
            $query->where('status', $status);
        }

        $products = $query->latest()->paginate(20);

        return response()->json([
            'label' => 'إدارة جميع المنتجات',
            'data' => $products
        ]);
    }

    /**
     * عرض تفاصيل منتج معين للأدمن
     */
    public function show($id): JsonResponse
    {
        $product = Product::with(['store', 'category'])->findOrFail($id);

        return response()->json([
            'label' => 'تفاصيل المنتج للمسؤول',
            'data' => $product
        ]);
    }

    /**
     * تحديث حالة منتج (موافقة/رفض/إخفاء) من قبل الأدمن
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|string|in:active,inactive,pending,rejected'
        ]);

        $product = Product::findOrFail($id);
        $product->update(['status' => $request->status]);

        return response()->json([
            'message' => 'تم تحديث حالة المنتج بنجاح من قبل الإدارة',
            'data' => $product
        ]);
    }
}
