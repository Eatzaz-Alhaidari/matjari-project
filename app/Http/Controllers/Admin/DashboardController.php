<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 1. حساب عدد البائعين
        $vendorCount = User::role('vendor')->count();

        // 2. حساب عدد المتاجر النشطة
        $activeStoresCount = Store::where('is_active', true)->count();

        // ##### الكود المضاف #####
        // 3. حساب عدد العملاء (المستخدمين الذين ليس لديهم أي دور)
        $customerCount = User::whereDoesntHave('roles')->count();

        // 4. Products Count
        $productCount = \App\Models\Product::count();

        // 5. Wallet Total Balance
        $walletTotalBalance = \App\Models\Wallet::sum('balance');

        // 6. Reviews Count
        $reviewCount = \App\Models\Review::count();

        // 7. Complaints Open Count
        $complaintOpenCount = \App\Models\Complaint::where('status', 'open')->count();

        // 8. Notifications Sent Count (Total in DB)
        $notificationCount = \Illuminate\Support\Facades\DB::table('notifications')->count();

        // 9. Financial Reports Count
        $financialReportsCount = \App\Models\Wallet::where('total_earnings', '>', 0)->count();

        // --- NEW STATISTICS ---
        // 10. Orders Count
        $ordersCount = \App\Models\Order::count();
        // 11. Returns Count (Placeholder)
        $returnsCount = 0;
        // 12. Shipping Count (Orders shipped or delivered)
        $shippingCount = \App\Models\Order::whereIn('status', ['shipped', 'delivered'])->count();
        // 13. Advertisements Count
        $advertisementCount = \App\Models\Advertisement::count();
        // 14. Discounts Count
        $discountCount = \App\Models\Discount::count();
        // 15. Inventory Count
        $inventoryCount = \App\Models\Product::sum('stock');
        // 16. Payment Management (Count of paid orders)
        $paymentCount = \App\Models\Order::where('payment_status', 'paid')->count();
        // 17. Customer Analysis (New Customers this month)
        $newCustomersCount = User::whereDoesntHave('roles')->where('created_at', '>=', now()->subDays(30))->count();

        // 18. Categories Count (New)
        $categoriesCount = \App\Models\Category::count();

        // 19. Activity Log Count (New - Placeholder)
        $activityLogCount = 0; // Or \App\Models\Activity::count(); if added later

        // --- CHART DATA ---

        // A. Sales Statistics (Last 30 Days) - Line Chart
        $salesData = \App\Models\Order::select(
            \Illuminate\Support\Facades\DB::raw('DATE(created_at) as date'),
            \Illuminate\Support\Facades\DB::raw('SUM(total_amount) as total')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $salesLabels = $salesData->pluck('date');
        $salesValues = $salesData->pluck('total');

        // B. Top Categories - Pie Chart
        // Join: order_items -> products -> categories
        $topCategories = \App\Models\OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', \Illuminate\Support\Facades\DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('categories.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        $categoryLabels = $topCategories->pluck('name');
        $categoryValues = $topCategories->pluck('total_quantity');


        // 4. إرسال كل هذه البيانات إلى الواجهة
        return view('admin.dashboard', [
            'vendorCount' => $vendorCount,
            'activeStoresCount' => $activeStoresCount,
            'customerCount' => $customerCount,
            'productCount' => $productCount,
            'walletTotalBalance' => $walletTotalBalance,
            'reviewCount' => $reviewCount,
            'complaintOpenCount' => $complaintOpenCount,
            'notificationCount' => $notificationCount,
            'financialReportsCount' => $financialReportsCount,
            'ordersCount' => $ordersCount,
            'returnsCount' => $returnsCount,
            'shippingCount' => $shippingCount,
            'advertisementCount' => $advertisementCount,
            'discountCount' => $discountCount,
            'inventoryCount' => $inventoryCount,
            'paymentCount' => $paymentCount,
            'newCustomersCount' => $newCustomersCount,
            'categoriesCount' => $categoriesCount,
            'activityLogCount' => $activityLogCount,
            // Chart Data
            'salesLabels' => $salesLabels,
            'salesValues' => $salesValues,
            'categoryLabels' => $categoryLabels,
            'categoryValues' => $categoryValues,
        ]);
    }
}