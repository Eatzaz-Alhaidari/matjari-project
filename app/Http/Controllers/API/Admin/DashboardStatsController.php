<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\Complaint;
use App\Models\Review;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\ActivityLog;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardStatsController extends Controller
{
    /**
     * API لبطاقة: إجمالي البائعين
     */
    public function getVendorsCount(): JsonResponse
    {
        $count = User::role('vendor')->count();
        return response()->json(['label' => 'إجمالي البائعين', 'value' => $count]);
    }

    /**
     * API لبطاقة: المتاجر النشطة
     */
    public function getActiveStoresCount(): JsonResponse
    {
        $count = Store::where('is_active', true)->count();
        return response()->json(['label' => 'المتاجر النشطة', 'value' => $count]);
    }

    /**
     * API لبطاقة: إجمالي العملاء
     */
    public function getCustomersCount(): JsonResponse
    {
        $count = User::whereDoesntHave('roles')->count();
        return response()->json(['label' => 'إجمالي العملاء', 'value' => $count]);
    }

    /**
     * API لبطاقة: إجمالي المنتجات
     */
    public function getProductsCount(): JsonResponse
    {
        $count = Product::count();
        return response()->json(['label' => 'إجمالي المنتجات', 'value' => $count]);
    }

    /**
     * API لبطاقة: إجمالي الطلبات
     */
    public function getOrdersCount(): JsonResponse
    {
        $count = Order::count();
        return response()->json(['label' => 'إجمالي الطلبات', 'value' => $count]);
    }

    /**
     * API لبطاقة: طلبات الإرجاع
     */
    public function getReturnsCount(): JsonResponse
    {
        $count = OrderReturn::count();
        return response()->json(['label' => 'طلبات الإرجاع', 'value' => $count]);
    }

    /**
     * API لبطاقة: الشكاوى المفتوحة
     */
    public function getOpenComplaintsCount(): JsonResponse
    {
        $count = Complaint::where('status', 'open')->count();
        return response()->json(['label' => 'الشكاوى المفتوحة', 'value' => $count]);
    }

    /**
     * API لبطاقة: إجمالي التقييمات
     */
    public function getReviewsCount(): JsonResponse
    {
        $count = Review::count();
        return response()->json(['label' => 'إجمالي التقييمات', 'value' => $count]);
    }

    /**
     * API لبطاقة: إجمالي الإشعارات المرسلة
     */
    public function getNotificationsCount(): JsonResponse
    {
        $count = DB::table('notifications')->count();
        return response()->json(['label' => 'إجمالي الإشعارات', 'value' => $count]);
    }

    /**
     * API لبطاقة: التقارير المالية (المحافظ النشطة)
     */
    public function getFinancialReportsCount(): JsonResponse
    {
        $count = Wallet::where('total_earnings', '>', 0)->count();
        return response()->json(['label' => 'التقارير المالية', 'value' => $count]);
    }

    /**
     * API لبطاقة: عمليات الشحن (مشحونة أو مستلمة)
     */
    public function getShippingCount(): JsonResponse
    {
        $count = Order::whereIn('status', ['shipped', 'delivered'])->count();
        return response()->json(['label' => 'عمليات الشحن', 'value' => $count]);
    }

    /**
     * API لبطاقة: إجمالي الإعلانات
     */
    public function getAdsCount(): JsonResponse
    {
        $count = Advertisement::count();
        return response()->json(['label' => 'إجمالي الإعلانات', 'value' => $count]);
    }

    /**
     * API لبطاقة: عمليات الدفع الناجحة
     */
    public function getPaymentsCount(): JsonResponse
    {
        $count = Order::where('payment_status', 'paid')->count();
        return response()->json(['label' => 'عمليات الدفع', 'value' => $count]);
    }

    /**
     * API لبطاقة: العملاء الجدد (آخر 30 يوم)
     */
    public function getNewCustomersCount(): JsonResponse
    {
        $count = User::whereDoesntHave('roles')->where('created_at', '>=', now()->subDays(30))->count();
        return response()->json(['label' => 'العملاء الجدد', 'value' => $count]);
    }

    /**
     * API لبطاقة: إجمالي الفئات (الرئيسية)
     */
    public function getCategoriesCount(): JsonResponse
    {
        $count = Category::whereNull('parent_id')->count();
        return response()->json(['label' => 'إجمالي الفئات', 'value' => $count]);
    }

    /**
     * API لبطاقة: سجلات النشاط
     */
    public function getActivityLogsCount(): JsonResponse
    {
        $count = ActivityLog::count();
        return response()->json(['label' => 'سجلات النشاط', 'value' => $count]);
    }

    /**
     * API لبطاقة: عناوين الشحن المسجلة
     */
    public function getShippingAddressesCount(): JsonResponse
    {
        $count = DB::table('addresses')->count();
        return response()->json(['label' => 'عناوين الشحن', 'value' => $count]);
    }

    /**
     * API لبطاقة: حركات المحفظة
     */
    public function getWalletTransactionsCount(): JsonResponse
    {
        $count = WalletTransaction::count();
        return response()->json(['label' => 'حركات المحفظة', 'value' => $count]);
    }

    /**
     * API لبطاقة: كوبونات الخصم النشطة
     */
    public function getActiveCouponsCount(): JsonResponse
    {
        $count = DB::table('discounts')->where('status', 'active')->count();
        return response()->json(['label' => 'الكوبونات النشطة', 'value' => $count]);
    }

    /**
     * API لبطاقة: أنشطة العملاء
     */
    public function getCustomerActivitiesCount(): JsonResponse
    {
        $count = DB::table('activity_logs')->count();
        return response()->json(['label' => 'أنشطة العملاء', 'value' => $count]);
    }
}
