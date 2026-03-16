<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

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
        // 1. التحقق من صحة البيانات (Validation)
        // نتوقع أن يكون الطلب عبارة عن مصفوفة (Array) تحتوي على كائنات
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            '*' => 'required|array',
            '*.code' => 'required',
            '*.qty' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في البيانات المرسلة من برنامج التزامن.',
                'errors' => $validator->errors()
            ], 422);
        }

        $items = $request->all(); 
        $updatedCount = 0;

        // 2. استخدام DB Transaction لضمان سلامة قاعدة البيانات وتسريع الأداء
        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            foreach ($items as $item) {
                // البحث باستخدام كود الصنف وتحديث حقلي الكمية
                $result = \App\Models\Product::where('product_code', $item['code']) 
                    ->update(['stock' => $item['qty']]);
                
                if ($result) {
                    $updatedCount++;
                }
            }

            \Illuminate\Support\Facades\DB::commit();

            return response()->json([
                'success' => true,
                'message' => "تمت المزامنة بنجاح. تم مسح وتحديث $updatedCount صنف من المخزون."
            ], 200);

        } catch (\Exception $e) {
            // في حال حدث أي خطأ برمجي، نلغي التعديلات لحماية الداتا베이스
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ داخلي في الخادم المحتضن للمتجر: ' . $e->getMessage()
            ], 500);
        }
    }
}