<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProductManagementController extends Controller
{
    /**
     * API لبطاقة: إدارة منتجات المتجر الخاص
     */
    public function index(Request $request): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $status = $request->get('status');

        $query = Product::where('store_id', $storeId)->with('category');

        if ($status) {
            $query->where('status', $status);
        }

        $products = $query->latest()->paginate(15);

        return response()->json([
            'label' => 'إدارة منتجات المتجر',
            'data' => $products
        ]);
    }

    /**
     * عرض تفاصيل منتج لصالح البائع
     */
    public function show($id): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $product = Product::where('store_id', $storeId)->with('category')->findOrFail($id);

        return response()->json([
            'label' => 'تفاصيل المنتج للبائع',
            'data' => $product
        ]);
    }

    /**
     * إضافة منتج جديد من قبل البائع
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        $data['store_id'] = auth()->user()->store->id;
        $data['status'] = 'pending'; // منتج جديد بانتظار الموافقة افتراضياً

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        return response()->json([
            'message' => 'تمت إضافة المنتج بنجاح، بانتظار موافقة الإدارة',
            'data' => $product
        ], 201);
    }

    /**
     * تحديث بيانات منتج من قبل البائع
     */
    public function update(Request $request, $id): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $product = Product::where('store_id', $storeId)->findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return response()->json([
            'message' => 'تم تحديث بيانات المنتج بنجاح',
            'data' => $product
        ]);
    }

    /**
     * حذف منتج من قبل البائع
     */
    public function destroy($id): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $product = Product::where('store_id', $storeId)->findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'message' => 'تم حذف المنتج بنجاح'
        ]);
    }

    /**
     * API لبطاقة: المنتجات الأكثر طلباً في متجر التاجر
     */
    public function getTopSellingProducts(): JsonResponse
    {
        $storeId = auth()->user()->store->id;

        $products = Product::where('store_id', $storeId)
            ->withCount(['orderItems as total_sales' => function ($query) {
                $query->select(\DB::raw('sum(quantity)'));
            }])
            ->orderByDesc('total_sales')
            ->take(10)
            ->get();

        return response()->json([
            'label' => 'المنتجات الأكثر طلباً',
            'data' => $products
        ]);
    }
}
