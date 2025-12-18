<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * عرض قائمة التقييمات لمنتجات المتجر
     */
    public function index(Request $request): View
    {
        $store = auth()->user()->store;
        
        $query = Review::whereHas('product', function ($q) use ($store) {
            $q->where('store_id', $store->id);
        })->with(['user', 'product']);

        // البحث حسب حالة التقييم
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // البحث حسب المنتج
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // البحث حسب التقييم
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->latest()->paginate(15);
        
        // الحصول على قائمة المنتجات للفلترة
        $products = Product::where('store_id', $store->id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        // إحصائيات التقييمات
        $stats = [
            'total' => Review::whereHas('product', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })->count(),
            'pending' => Review::whereHas('product', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })->where('status', 'pending')->count(),
            'approved' => Review::whereHas('product', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })->where('status', 'approved')->count(),
            'rejected' => Review::whereHas('product', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })->where('status', 'rejected')->count(),
            'average_rating' => Review::whereHas('product', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })->where('status', 'approved')->avg('rating') ?? 0,
        ];

        return view('vendor.reviews.index', compact('reviews', 'products', 'stats'));
    }

    /**
     * عرض تفاصيل تقييم معين
     */
    public function show(Review $review): View
    {
        $store = auth()->user()->store;
        
        // التأكد من أن التقييم يخص منتج من متجر البائع
        if ($review->product->store_id !== $store->id) {
            abort(403, 'غير مصرح لك بالوصول إلى هذا التقييم');
        }

        $review->load(['user', 'product']);
        
        return view('vendor.reviews.show', compact('review'));
    }

    /**
     * تحديث حالة التقييم (قبول/رفض)
     */
    public function updateStatus(Request $request, Review $review)
    {
        $store = auth()->user()->store;
        
        // التأكد من أن التقييم يخص منتج من متجر البائع
        if ($review->product->store_id !== $store->id) {
            abort(403, 'غير مصرح لك بتعديل هذا التقييم');
        }

        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $review->update([
            'status' => $request->status
        ]);

        $statusText = match($request->status) {
            'approved' => 'تم قبول التقييم',
            'rejected' => 'تم رفض التقييم',
            'pending' => 'تم إرجاع التقييم للمراجعة',
            default => 'تم تحديث حالة التقييم'
        };

        return redirect()->route('vendor.reviews.index')
            ->with('success', $statusText);
    }
}







