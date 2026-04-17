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
            'products.*.stock' => 'nullable|integer',
            // Allow stock OR qty OR quantity
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $syncedCount = 0;
        $defaultStore = Store::first(); // Or use a specific C# Integration Store
        $defaultCategory = Category::first();

        foreach ($data['products'] as $item) {
            // Determine stock value from various possible keys
            $stock = $item['stock'] ?? ($item['qty'] ?? ($item['quantity'] ?? 0));
            
            $product = Product::where('product_code', $item['product_code'])->first();

            if ($product) {
                // If product exists, only update stock to preserve manual edits in Dashboard
                $product->update([
                    'stock' => $stock
                ]);
            } else {
                // If new product, create with default values
                $product = Product::create([
                    'product_code' => $item['product_code'],
                    'name' => $item['name'] ?? ('جديد - ' . $item['product_code']),
                    'price' => $item['price'] ?? 0,
                    'stock' => $stock,
                    'status' => 'inactive', // Default to inactive for admin review
                    'store_id' => $defaultStore ? $defaultStore->id : 1,
                    'category_id' => $defaultCategory ? $defaultCategory->id : 1,
                    'category' => 'غير مصنف', // Default category value to fix 500 error
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
