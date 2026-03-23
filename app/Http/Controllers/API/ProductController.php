<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * عرض المنتجات
     */
    public function index(Request $request)
    {
        $query = Product::with([
            'category:id,name',
            'store:id,name',
            'images'
        ])
            ->where('status', 'active');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Support for Flutter app 'category' parameter (slug)
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(10);

        // ✅ إضافة رابط الصورة + دعم صور متعددة
        foreach ($products as $product) {

            // صورة رئيسية
            $product->image_url = $product->image
                ? url('api/image/' . $product->image)
                : null;

            // صور إضافية لو موجودة
            if ($product->images) {
                $images = [];

                foreach ($product->images as $img) {
                    $images[] = url('api/image/' . $img->image_path);
                }

                $product->images_url = $images;
            } else {
                $product->images_url = [];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * عرض منتج واحد
     */
    public function show($id)
    {
        $product = Product::with([
            'category',
            'store',
            'images',
            'reviews.user:id,name'
        ])
            ->where('status', 'active')
            ->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // ✅ الصورة الرئيسية
        $product->image_url = $product->image
            ? url('api/image/' . $product->image)
            : null;

        // ✅ صور متعددة
        if ($product->images) {
            $images = [];

            foreach ($product->images as $img) {
                $images[] = url('api/image/' . $img->image_path);
            }

            $product->images_url = $images;
        } else {
            $product->images_url = [];
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function syncFromDesktop(Request $request)
    {
        $payload = $request->all();
        $defaultStoreId = null;
        $items = [];

        // يدعم شكلين:
        // 1) [ { code/sku/product_id, qty/quantity, store_id? }, ... ]
        // 2) { store_id: 1, items: [ ... ] }
        if (isset($payload['items']) && is_array($payload['items'])) {
            $items = $payload['items'];
            $defaultStoreId = $payload['store_id'] ?? null;
        } elseif (is_array($payload) && array_is_list($payload)) {
            $items = $payload;
            $defaultStoreId = $request->input('store_id');
        } else {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'صيغة البيانات غير صحيحة. أرسل items كمصفوفة.',
            ], 422);
        }

        if (empty($items)) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'لا توجد بيانات مزامنة.',
            ], 422);
        }

        $updatedCount = 0;
        $notFound = [];
        $invalidRows = [];

        try {
            DB::beginTransaction();

            foreach ($items as $index => $item) {
                $rowNumber = $index + 1;

                if (!is_array($item)) {
                    $invalidRows[] = [
                        'row' => $rowNumber,
                        'reason' => 'row is not an object',
                    ];
                    continue;
                }

                $identifier = $item['product_id']
                    ?? $item['id']
                    ?? $item['code']
                    ?? $item['product_code']
                    ?? $item['sku']
                    ?? null;

                $qty = $item['qty']
                    ?? $item['quantity']
                    ?? $item['stock']
                    ?? null;

                $storeId = $item['store_id'] ?? $defaultStoreId;

                $validator = Validator::make([
                    'identifier' => $identifier,
                    'qty' => $qty,
                    'store_id' => $storeId,
                ], [
                    'identifier' => 'required',
                    'qty' => 'required|numeric|min:0',
                    'store_id' => 'nullable|integer|exists:stores,id',
                ]);

                if ($validator->fails()) {
                    $invalidRows[] = [
                        'row' => $rowNumber,
                        'identifier' => $identifier,
                        'errors' => $validator->errors()->all(),
                    ];
                    continue;
                }

                $query = Product::query();

                if (is_numeric($identifier)) {
                    $query->where('id', (int) $identifier);
                } else {
                    $query->where(function ($q) use ($identifier) {
                        $q->where('product_code', $identifier)
                            ->orWhere('sku', $identifier);
                    });
                }

                if (!empty($storeId)) {
                    $query->where('store_id', (int) $storeId);
                }

                $updated = $query->update(['stock' => (int) round((float) $qty)]);

                if ($updated > 0) {
                    $updatedCount += $updated;
                } else {
                    $notFound[] = [
                        'row' => $rowNumber,
                        'identifier' => $identifier,
                        'store_id' => $storeId,
                    ];
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => 'تم تحديث المخزون بنجاح',
                'updated_products' => $updatedCount,
                'not_found_count' => count($notFound),
                'invalid_rows_count' => count($invalidRows),
                'not_found' => $notFound,
                'invalid_rows' => $invalidRows,
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'حدث خطأ داخلي في الخادم: ' . $e->getMessage(),
            ], 500);
        }
    }
}