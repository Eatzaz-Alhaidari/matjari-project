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
        // استلام البيانات المرسلة من برنامج الـ C#
        $items = $request->all(); 

        $updatedCount = 0;
        foreach ($items as $item) {
            // البحث باستخدام product_code وتحديث حقل stock
            $result = \App\Models\Product::where('product_code', $item['code']) 
                ->update(['stock' => $item['qty']]);
            
            if ($result) {
                $updatedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "تمت المزامنة بنجاح. تم تحديث $updatedCount صنف."
        ]);
    }
}