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
        // Handle direct array payloads (sent by older/simple REST clients)
        $data = $request->all();
        if (isset($data[0])) {
            $data = ['products' => $data];
        }

        $validator = Validator::make($data, [
            'products' => 'required|array',
            'products.*.product_code' => 'required|string',
            'products.*.name' => 'nullable|string',
            'products.*.price' => 'nullable|numeric',
            // Allow stock OR qty OR quantity
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $syncedCount = 0;
        $defaultStore = Store::first();
        $defaultCategory = Category::first();

        foreach ($data['products'] as $item) {
            // Determine stock value from various possible keys
            $stock = $item['stock'] ?? ($item['qty'] ?? ($item['quantity'] ?? 0));
            
            $product = Product::where('product_code', $item['product_code'])->first();

            if ($product) {
                $product->update([
                    'stock' => $stock
                ]);
            } else {
                $product = Product::create([
                    'product_code' => $item['product_code'],
                    'name' => $item['name'] ?? ('جديد - ' . $item['product_code']),
                    'price' => $item['price'] ?? 0,
                    'stock' => $stock,
                    'status' => 'inactive',
                    'store_id' => $defaultStore ? $defaultStore->id : 1,
                    'category_id' => $defaultCategory ? $defaultCategory->id : 1,
                    'manual_category' => 'غير مصنف', // Use manual_category to avoid conflict
                    'description' => 'تم استيراده تلقائياً من تطبيق C#',
                    'currency' => 'YER',
                ]);
            }

            event(new ProductQtyUpdated($product->product_code, $product->stock));
            $syncedCount++;
        }

        return $this->sendResponse(['synced_count' => $syncedCount], 'تمت مزامنة المخزون بنجاح');
    }
}
