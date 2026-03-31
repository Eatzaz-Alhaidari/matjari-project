<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
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
            'brand:id,name,logo',
            'images'
        ])
            ->where('status', 'active');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('brand_id')) {
            $query->where('brand_id', $request->brand_id);
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

            // ماركة لو موجودة
            if ($product->brand) {
                $product->brand_name = $product->brand->name;
                $product->brand_logo_url = $product->brand->logo 
                    ? url('api/image/' . $product->brand->logo) 
                    : null;
            } else {
                $product->brand_name = $product->brand; // Fallback to old field
            }

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
        // استخراج التاجر من الـ Token
        $user = auth('sanctum')->user();
        if (!$user || !$user->store) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'بيانات التاجر غير صالحة، أو لا يمتلك متجراً مرتبطاً بحسابه.',
            ], 403);
        }
        $authenticatedStoreId = $user->store->id;

        $payload = $request->all();
        $items = [];

        // يدعم شكلين:
        // 1) [ { code/sku/product_id, qty/quantity }, ... ]
        // 2) { items: [ ... ] }
        if (isset($payload['items']) && is_array($payload['items'])) {
            $items = $payload['items'];
        } elseif (is_array($payload) && array_is_list($payload)) {
            $items = $payload;
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

                // نستخدم رقم المتجر الخاص بالتاجر الحالي (ملغي أي قيمة يتم إرسالها من الديسكتوب كنوع من الأمان)
                $storeId = $authenticatedStoreId;

                $validator = Validator::make([
                    'identifier' => $identifier,
                    'qty' => $qty,
                ], [
                    'identifier' => 'required',
                    'qty' => 'required|numeric|min:0',
                ]);

                if ($validator->fails()) {
                    $invalidRows[] = [
                        'row' => $rowNumber,
                        'identifier' => $identifier,
                        'errors' => $validator->errors()->all(),
                    ];
                    continue;
                }

                $product = null;

                // 1) إذا تم إرسال ID صريح.
                if (!empty($item['product_id'])) {
                    $product = Product::where('id', (int) $item['product_id'])
                        ->when($storeId, fn($q) => $q->where('store_id', (int) $storeId))
                        ->first();
                } elseif (!empty($item['id'])) {
                    $product = Product::where('id', (int) $item['id'])
                        ->when($storeId, fn($q) => $q->where('store_id', (int) $storeId))
                        ->first();
                }

                // 2) البحث بالكود/الرقم المرسل، مع دعم product_code و sku
                if (!$product && !empty($identifier)) {
                    $query = Product::query();

                    if (is_numeric($identifier)) {
                        // يمكن أن يكون SKU أو product_code رقمي
                        $query->where(function ($q) use ($identifier) {
                            $q->where('id', (int) $identifier)
                                ->orWhere('product_code', $identifier)
                                ->orWhere('sku', $identifier);
                        });
                    } else {
                        $query->where(function ($q) use ($identifier) {
                            $q->where('product_code', $identifier)
                                ->orWhere('sku', $identifier);
                        });
                    }

                    if (!empty($storeId)) {
                        $query->where('store_id', (int) $storeId);
                    }

                    $product = $query->first();
                }

                if (!$product) {
                    // إنشاء المنتج كمسودة (غير نشط) ليتوافق مع قاعدة البيانات حتى لو لم يكن موجوداً
                    $categoryId = \App\Models\Category::first()->id ?? 1;

                    $product = new Product();
                    $product->product_code = $identifier;
                    // استخدام الاسم المرسل أو وضع اسم افتراضي لتمييزه وتسهيل تعديله لاحقاً من لوحة التحكم
                    $product->name = !empty($item['name']) ? $item['name'] : ('منتج تلقائي - ' . $identifier); 
                    $product->description = 'تمت إضافته آلياً عبر المزامنة من نظام الديسكتوب';
                    $product->price = isset($item['price']) ? (float) $item['price'] : 0;
                    $product->stock = (int) round((float) $qty);
                    $product->store_id = $storeId ?? 1;
                    $product->category_id = $categoryId;
                    $product->status = 'inactive'; // منتج غير نشط حتى يقوم المدير بتسعيره
                    $product->save();
                    
                    $updatedCount++;
                    continue; // تم إنشاء المنتج وحفظه
                }

                $product->stock = (int) round((float) $qty);
                // تحديث الاسم والسعر في حال تم إرسالهم ولم يكونوا فارغين
                if (!empty($item['name'])) {
                    $product->name = $item['name'];
                }
                if (isset($item['price'])) {
                    $product->price = (float) $item['price'];
                }
                $product->save();
                $updatedCount++;
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

    /**
     * المنتجات الأكثر طلباً
     */
    public function getTopSellingProducts(Request $request)
    {
        $query = Product::with('category:id,name')
            ->where('products.status', 'active')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'products.id',
                'products.name',
                'products.category_id',
                'products.brand',
                'products.price',
                'products.stock',
                'products.image',
                DB::raw('SUM(order_items.quantity) as sold_quantity')
            )
            ->groupBy(
                'products.id',
                'products.name',
                'products.category_id',
                'products.brand',
                'products.price',
                'products.stock',
                'products.image'
            )
            ->orderByDesc('sold_quantity');

        // فلتر زمني اختياري
        if ($request->has('days')) {
            $days = (int) $request->get('days');
            $startDate = now()->subDays($days)->startOfDay();
            $query->where('orders.created_at', '>=', $startDate);
        }

        // تحديد عدد المنتجات المرجعة
        $limit = $request->get('limit', 10);
        $topProducts = $query->limit((int) $limit)->get();

        // تنسيق البيانات حسب المطلوب
        $formattedProducts = $topProducts->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category ? $product->category->name : 'بدون تصنيف',
                'brand' => $product->brand,
                'current_price' => (float) $product->price,
                'stock' => (int) $product->stock,
                'sold_quantity' => (int) $product->sold_quantity,
                'image_url' => $product->image ? url('api/image/' . $product->image) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedProducts
        ]);
    }
}