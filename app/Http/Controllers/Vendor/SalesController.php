<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SalesController extends Controller
{
    /**
     * Display sales dashboard
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Check if user has a store
        if (!$user->store) {
            return redirect()->route('vendor.dashboard')->with('error', 'يجب إنشاء متجر أولاً قبل عرض إحصائيات المبيعات.');
        }

        $storeId = $user->store->id;

        // Date range filter
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Sales Statistics
        $stats = [
            'total_sales' => Order::where('store_id', $storeId)
                ->where('status', 'delivered')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_amount'),

            'total_orders' => Order::where('store_id', $storeId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),

            'completed_orders' => Order::where('store_id', $storeId)
                ->where('status', 'delivered')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),

            'pending_orders' => Order::where('store_id', $storeId)
                ->where('status', 'pending')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),

            'processing_orders' => Order::where('store_id', $storeId)
                ->where('status', 'processing')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),

            'shipped_orders' => Order::where('store_id', $storeId)
                ->where('status', 'shipped')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),

            'cancelled_orders' => Order::where('store_id', $storeId)
                ->where('status', 'cancelled')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
        ];

        // Monthly Sales Chart Data
        $monthlySales = Order::where('store_id', $storeId)
            ->where('status', 'delivered')
            ->whereYear('created_at', Carbon::now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Top Selling Products
        $topProducts = Product::where('products.store_id', $storeId)
            ->withCount(['orderItems as sold_quantity' => function ($query) use ($startDate, $endDate, $storeId) {
                $query->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.store_id', $storeId)
                    ->where('orders.status', 'delivered')
                    ->whereBetween('orders.created_at', [$startDate, $endDate]);
            }])
            ->having('sold_quantity', '>', 0)
            ->orderBy('sold_quantity', 'desc')
            ->take(10)
            ->get();

        // Recent Orders
        $recentOrders = Order::where('store_id', $storeId)
            ->with(['user'])
            ->latest()
            ->take(10)
            ->get();

        // Sales by Status Chart
        $salesByStatus = Order::where('store_id', $storeId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('vendor.sales.index', compact(
            'stats',
            'monthlySales',
            'topProducts',
            'recentOrders',
            'salesByStatus',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Export sales report
     */
    public function export(Request $request)
    {
        $user = auth()->user();

        // Check if user has a store
        if (!$user->store) {
            return response()->json(['error' => 'يجب إنشاء متجر أولاً'], 403);
        }

        $storeId = $user->store->id;
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $orders = Order::where('store_id', $storeId)
            ->where('status', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['user', 'orderItems.product'])
            ->get();

        // Here you could implement CSV/PDF export
        // For now, just return JSON
        return response()->json($orders);
    }
}
