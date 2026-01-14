<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

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
                    $query->whereRaw('stock <= min_stock');
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
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(15);

        // إحصائيات المخزون
        $stats = [
            'total_products' => Product::where('store_id', auth()->user()->store->id)->count(),
            'out_of_stock' => Product::where('store_id', auth()->user()->store->id)->where('stock', 0)->count(),
            'low_stock' => Product::where('store_id', auth()->user()->store->id)->whereRaw('stock <= min_stock')->count(),
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
     * Step 1: Upload CSV and Show Mapping Interface
     */
    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('csv_file');

        // Ensure the directory exists using Storage disk
        if (!Storage::disk('local')->exists('temp')) {
            Storage::disk('local')->makeDirectory('temp');
        }

        $filename = 'temp/import_' . auth()->id() . '_' . time() . '.csv';
        $path = $file->storeAs('', $filename, 'local');
        $fullPath = Storage::disk('local')->path($path);

        $fileHandle = fopen($fullPath, 'r');
        $header = fgetcsv($fileHandle);
        fclose($fileHandle);

        if (!$header) {
            return back()->with('error', 'الملف فارغ أو غير صالح');
        }

        // Clean header BOM if exists
        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);

        // Database fields to map
        $dbFields = [
            'product_code' => 'رمز المنتج (product_code)',
            'name' => 'اسم المنتج (product_name)',
            'stock' => 'كمية المنتج (quantity)',
            'cost_price' => 'تكلفة الشراء (cost_price)',
            'price_before' => 'سعر البيع قبل الخصم (price_before)',
            'price' => 'سعر البيع بعد الخصم (price_after)',
            'min_stock' => 'الحد الأدنى للمخزون (min_stock)',
            'notes' => 'ملاحظات (notes)',
        ];

        return view('vendor.warehouse.mapping', [
            'headers' => $header,
            'dbFields' => $dbFields,
            'temp_file' => $path
        ]);
    }

    /**
     * Step 2: Process Mapping and Import Logic
     */
    public function processImport(Request $request)
    {
        $request->validate([
            'temp_file' => 'required|string',
            'mapping' => 'required|array',
            'on_missing' => 'required|in:skip,create',
        ]);

        $path = $request->temp_file;
        $mapping = $request->mapping; // csv_index => db_field
        $onMissing = $request->on_missing;
        $storeId = auth()->user()->store->id;

        $fullPath = Storage::disk('local')->path($path);
        if (!file_exists($fullPath)) {
            return redirect()->route('vendor.warehouse.import')->with('error', 'انتهت صلاحية الجلسة أو الملف غير موجود');
        }

        $fileHandle = fopen($fullPath, 'r');
        fgetcsv($fileHandle); // Skip header

        $results = [
            'success' => 0,
            'errors' => [],
            'row_count' => 0
        ];

        // Default category for new products if missing
        $defaultCategory = Category::first();

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($fileHandle)) !== false) {
                $results['row_count']++;
                $data = [];

                // Map values
                foreach ($mapping as $csvIndex => $dbField) {
                    if ($dbField && isset($row[$csvIndex])) {
                        $data[$dbField] = trim($row[$csvIndex]);
                    }
                }

                // Validation
                if (empty($data['product_code'])) {
                    $results['errors'][] = "الصف " . ($results['row_count'] + 1) . ": رمز المنتج فارغ";
                    continue;
                }

                if (isset($data['stock']) && !is_numeric($data['stock'])) {
                    $results['errors'][] = "الصف " . ($results['row_count'] + 1) . ": الكمية يجب أن تكون رقماً";
                    continue;
                }

                foreach (['price', 'cost_price', 'price_before'] as $priceField) {
                    if (isset($data[$priceField]) && (!is_numeric($data[$priceField]) || $data[$priceField] < 0)) {
                        $results['errors'][] = "الصف " . ($results['row_count'] + 1) . ": السعر يجب أن يكون رقماً موجباً (" . ($dbField ?? $priceField) . ")";
                        continue 2;
                    }
                }

                $product = Product::where('store_id', $storeId)
                    ->where('product_code', $data['product_code'])
                    ->first();

                if ($product) {
                    $product->update($data);
                    $results['success']++;
                } else {
                    if ($onMissing === 'create') {
                        // For creation, we need at least a name
                        if (empty($data['name'])) {
                            $results['errors'][] = "الصف " . ($results['row_count'] + 1) . ": لا يمكن إنشاء منتج جديد بدون اسم";
                            continue;
                        }

                        $data['store_id'] = $storeId;
                        $data['category_id'] = $data['category_id'] ?? ($defaultCategory->id ?? 1);
                        $data['description'] = $data['description'] ?? $data['notes'] ?? 'تم استيراده عبر CSV';

                        Product::create($data);
                        $results['success']++;
                    } else {
                        $results['errors'][] = "الصف " . ($results['row_count'] + 1) . ": المنتج غير موجود (كود: " . $data['product_code'] . ")";
                    }
                }
            }

            DB::commit();
            Storage::delete($path);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('CSV Import Error: ' . $e->getMessage());
            return redirect()->route('vendor.warehouse.import')->with('error', 'حدث خطأ أثناء الاستيراد: ' . $e->getMessage());
        }

        return view('vendor.warehouse.import_result', ['results' => $results]);
    }

    /**
     * Download CSV Template
     */
    public function downloadTemplate()
    {
        $headers = [
            'product_code',
            'product_name',
            'quantity',
            'cost_price',
            'price_before',
            'price_after',
            'min_stock',
            'notes'
        ];

        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel
            fgetcsv($file); // Workaround
            fputcsv($file, [
                'رمز المنتج (product_code)',
                'اسم المنتج (product_name)',
                'الكمية (quantity)',
                'تكلفة الشراء (cost_price)',
                'سعر البيع قبل الخصم (price_before)',
                'سعر البيع بعد الخصم (price_after)',
                'الحد الأدنى للمخزون (min_stock)',
                'ملاحظات (notes)'
            ]);

            // Example row
            fputcsv($file, [
                'EX-100',
                'منتج تجريبي',
                '50',
                '10.00',
                '20.00',
                '15.00',
                '5',
                'ملاحظات اختيارية'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=products_template.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
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
            ->whereRaw('stock <= min_stock')
            ->count();
    }
}
