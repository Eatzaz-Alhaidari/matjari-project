<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Advertisement;
use App\Models\Discount;
use App\Models\Review;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardStatsController extends Controller
{
    /**
     * API لبطاقة: إجمالي المنتجات
     */
    public function getTotalProducts(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $count = Product::where('store_id', $storeId)->count();
        return response()->json(['label' => 'إجمالي المنتجات', 'value' => $count]);
    }

    /**
     * API لبطاقة: المنتجات النشطة
     */
    public function getActiveProducts(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $count = Product::where('store_id', $storeId)->where('status', 'active')->count();
        return response()->json(['label' => 'المنتجات النشطة', 'value' => $count]);
    }

    /**
     * API لبطاقة: المنتجات غير النشطة
     */
    public function getInactiveProducts(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $count = Product::where('store_id', $storeId)->where('status', 'inactive')->count();
        return response()->json(['label' => 'المنتجات غير النشطة', 'value' => $count]);
    }

    /**
     * API لبطاقة: إجمالي الطلبات
     */
    public function getTotalOrders(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $count = Order::where('store_id', $storeId)->count();
        return response()->json(['label' => 'إجمالي الطلبات', 'value' => $count]);
    }

    /**
     * API لبطاقة: طلبات بانتظار الموافقة
     */
    public function getPendingOrders(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $count = Order::where('store_id', $storeId)->where('status', 'pending')->count();
        return response()->json(['label' => 'طلبات بانتظار الموافقة', 'value' => $count]);
    }

    /**
     * API لبطاقة: طلبات قيد التجهيز
     */
    public function getProcessingOrders(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $count = Order::where('store_id', $storeId)->where('status', 'processing')->count();
        return response()->json(['label' => 'طلبات قيد التجهيز', 'value' => $count]);
    }

    /**
     * API لبطاقة: طلبات تم شحنها
     */
    public function getShippedOrders(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $count = Order::where('store_id', $storeId)->where('status', 'shipped')->count();
        return response()->json(['label' => 'طلبات تم شحنها', 'value' => $count]);
    }

    /**
     * API لبطاقة: طلبات تم تسليمها
     */
    public function getDeliveredOrders(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $count = Order::where('store_id', $storeId)->where('status', 'delivered')->count();
        return response()->json(['label' => 'طلبات تم تسليمها', 'value' => $count]);
    }

    /**
     * API لبطاقة: إجمالي المبيعات
     */
    public function getTotalSales(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $sum = Order::where('store_id', $storeId)->where('status', 'delivered')->sum('total_amount');
        return response()->json(['label' => 'إجمالي المبيعات', 'value' => $sum, 'currency' => 'YER']);
    }

    /**
     * API لبطاقة: منتجات منخفضة المخزون
     */
    public function getLowStockCount(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $count = Product::where('store_id', $storeId)->whereRaw('stock <= min_stock')->count();
        return response()->json(['label' => 'مخزون منخفض', 'value' => $count]);
    }

    /**
     * API لبطاقة: الإعلانات النشطة
     */
    public function getActiveAdsCount(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $count = Advertisement::where('store_id', $storeId)->where('status', 'active')->count();
        return response()->json(['label' => 'إعلانات نشطة', 'value' => $count]);
    }

    /**
     * API لبطاقة: الخصومات النشطة
     */
    public function getActiveDiscountsCount(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $count = Discount::where('store_id', $storeId)->where('status', 'active')->count();
        return response()->json(['label' => 'خصومات نشطة', 'value' => $count]);
    }

    /**
     * API لبطاقة: إجمالي التقييمات
     */
    public function getTotalReviewsCount(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $count = Review::whereHas('product', function ($q) use ($storeId) {
            $q->where('store_id', $storeId);
        })->count();
        return response()->json(['label' => 'إجمالي التقييمات', 'value' => $count]);
    }

    /**
     * API لبطاقة: تقييمات بانتظار المراجعة
     */
    public function getPendingReviewsCount(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $count = Review::whereHas('product', function ($q) use ($storeId) {
            $q->where('store_id', $storeId);
        })->where('status', 'pending')->count();
        return response()->json(['label' => 'تقييمات معلقة', 'value' => $count]);
    }

    /**
     * API لبطاقة: متوسط التقييم
     */
    public function getAverageRating(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $avg = Review::whereHas('product', function ($q) use ($storeId) {
            $q->where('store_id', $storeId);
        })->where('status', 'approved')->avg('rating') ?? 0;
        return response()->json(['label' => 'متوسط التقييم', 'value' => round($avg, 1)]);
    }

    /**
     * API لبطاقة: رصيد المحفظة
     */
    public function getWalletBalance(): JsonResponse
    {
        $userId = auth()->id();
        $wallet = Wallet::where('user_id', $userId)->first();
        $balance = $wallet ? $wallet->balance : 0;
        return response()->json(['label' => 'رصيد المحفظة', 'value' => $balance, 'currency' => 'YER']);
    }

    /**
     * API لبطاقة: إجمالي الأرباح
     */
    public function getTotalEarnings(): JsonResponse
    {
        $userId = auth()->id();
        $wallet = Wallet::where('user_id', $userId)->first();
        $earnings = $wallet ? $wallet->total_earnings : 0;
        return response()->json(['label' => 'إجمالي الأرباح', 'value' => $earnings, 'currency' => 'YER']);
    }
}
