<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use App\Models\Store;
use App\Models\Category;
use App\Events\ProductQtyUpdated;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InventoryController extends BaseController
{
    /**
     * Sync inventory/products from external C# application.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function syncProducts(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'products' => 'required|array',
            'products.*.product_code' => 'required|string',
            'products.*.name' => 'nullable|string',
            'products.*.price' => 'nullable|numeric',
            'products.*.stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $syncedCount = 0;
        $defaultStore = Store::first(); // Or use a specific C# Integration Store
        $defaultCategory = Category::first();

        foreach ($request->products as $item) {
            $product = Product::where('product_code', $item['product_code'])->first();

            if ($product) {
                // If product exists, only update stock to preserve manual edits in Dashboard
                $product->update([
                    'stock' => $item['stock']
                ]);
            } else {
                // If new product, create with default values
                $product = Product::create([
                    'product_code' => $item['product_code'],
                    'name' => $item['name'] ?? ('جديد - ' . $item['product_code']),
                    'price' => $item['price'] ?? 0,
                    'stock' => $item['stock'],
                    'status' => 'inactive', // Default to inactive for admin review
                    'store_id' => $defaultStore ? $defaultStore->id : 1,
                    'category_id' => $defaultCategory ? $defaultCategory->id : 1,
                    'description' => 'تم استيراده تلقائياً من تطبيق C#',
                    'currency' => 'YER',
                ]);
            }

            // Trigger real-time update in Dashboard
            event(new ProductQtyUpdated($product->product_code, $product->stock));
            
            $syncedCount++;
        }

        return $this->sendResponse(['synced_count' => $syncedCount], 'تمت مزامنة المخزون بنجاح');
    }
}
