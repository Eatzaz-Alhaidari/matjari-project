<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of products with low stock.
     */
    public function index(Request $request)
    {
        $query = Product::where('store_id', auth()->user()->store->id)
            ->with(['store', 'category']);

        // فلترة حسب حالة المخزون
        if ($request->has('stock_status') && $request->stock_status != '') {
            switch ($request->stock_status) {
                case 'out_of_stock':
                    $query->where('stock', 0);
                    break;
                case 'low_stock':
                    $query->where('stock', '>', 0)->where('stock', '<=', 5);
                    break;
                case 'medium_stock':
                    $query->where('stock', '>', 5)->where('stock', '<=', 20);
                    break;
                case 'good_stock':
                    $query->where('stock', '>', 20);
                    break;
            }
        }

        // البحث
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(15);

        // إحصائيات المخزون
        $stats = [
            'total_products' => Product::where('store_id', auth()->user()->store->id)->count(),
            'out_of_stock' => Product::where('store_id', auth()->user()->store->id)->where('stock', 0)->count(),
            'low_stock' => Product::where('store_id', auth()->user()->store->id)->where('stock', '>', 0)->where('stock', '<=', 5)->count(),
            'medium_stock' => Product::where('store_id', auth()->user()->store->id)->where('stock', '>', 5)->where('stock', '<=', 20)->count(),
            'good_stock' => Product::where('store_id', auth()->user()->store->id)->where('stock', '>', 20)->count(),
        ];

        return view('vendor.warehouse.index', compact('products', 'stats'));
    }

    /**
     * Show the import form.
     */
    public function import()
    {
        return view('vendor.warehouse.import');
    }

    /**
     * Process the imported CSV file.
     */
    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');

        // Skip header row if exists
        $header = fgetcsv($handle);

        $successCount = 0;
        $errors = [];
        $row = 1;

        while (($data = fgetcsv($handle)) !== false) {
            $row++;
            // Assuming CSV format: product_id, stock
            if (count($data) < 2) {
                $errors[] = "Row {$row}: Invalid format";
                continue;
            }

            $productId = $data[0];
            $stock = (int) $data[1];

            $product = Product::where('id', $productId)
                ->where('store_id', auth()->user()->store->id)
                ->first();

            if ($product) {
                $product->update(['stock' => $stock]);
                $successCount++;
            } else {
                $errors[] = "Row {$row}: Product ID {$productId} not found or unauthorized";
            }
        }

        fclose($handle);

        if (count($errors) > 0) {
            return redirect()->route('vendor.warehouse.index')
                ->with('success', "Processed {$successCount} products successfully.")
                ->with('error', "Errors encountered: " . implode(', ', array_slice($errors, 0, 5)));
        }

        return redirect()->route('vendor.warehouse.index')
            ->with('success', "All {$successCount} products updated successfully.");
    }

    /**
     * Update the stock of a product.
     */
    public function updateStock(Request $request, Product $product)
    {
        // التأكد من أن المنتج ينتمي لمتجر البائع
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بتعديل هذا المنتج');
        }

        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product->update(['stock' => $request->stock]);

        return redirect()->back()->with('success', 'تم تحديث المخزون بنجاح');
    }

    /**
     * Get low stock products count for dashboard.
     */
    public static function getLowStockCount()
    {
        return Product::where('store_id', auth()->user()->store->id)
            ->where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->count();
    }
}
