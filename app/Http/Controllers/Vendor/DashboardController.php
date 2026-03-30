<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use App\Models\Order;
use App\Models\Advertisement;
use App\Models\Discount;
use App\Models\Review;
use App\Models\OrderItem;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Vendor\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View|string
    {
        $store = auth()->user()->store;
        if (!$store) {
            abort(403, 'عذراً، حسابك كبائع لا يمتلك متجراً مرتبطاً به حالياً. يرجى التواصل مع الإدارة لإنشاء وربط متجرك.');
        }

        // حساب الإحصائيات
        $stats = [
            'total_products' => Product::where('store_id', $store->id)->count(),
            'active_products' => Product::where('store_id', auth()->user()->store->id)->where('status', 'active')->count(),
            'inactive_products' => Product::where('store_id', auth()->user()->store->id)->where('status', 'inactive')->count(),
            'total_orders' => Order::where('store_id', auth()->user()->store->id)->count(),
            'pending_orders' => Order::where('store_id', auth()->user()->store->id)->where('status', 'pending')->count(),
            'processing_orders' => Order::where('store_id', auth()->user()->store->id)->where('status', 'processing')->count(),
            'shipped_orders' => Order::where('store_id', auth()->user()->store->id)->where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('store_id', auth()->user()->store->id)->where('status', 'delivered')->count(),
            'total_sales' => Order::where('store_id', auth()->user()->store->id)->where('status', 'delivered')->sum('total_amount'),
            'low_stock_products' => Product::where('store_id', auth()->user()->store->id)->whereRaw('stock <= min_stock')->count(),
            'active_advertisements' => Advertisement::where('store_id', auth()->user()->store->id)->where('status', 'active')->count(),
            'active_discounts' => Discount::where('store_id', auth()->user()->store->id)->where('status', 'active')->count(),
            'total_reviews' => Review::whereHas('product', function ($q) {
                $q->where('store_id', auth()->user()->store->id);
            })->count(),
            'pending_reviews' => Review::whereHas('product', function ($q) {
                $q->where('store_id', auth()->user()->store->id);
            })->where('status', 'pending')->count(),
            'average_rating' => Review::whereHas('product', function ($q) {
                $q->where('store_id', auth()->user()->store->id);
            })->where('status', 'approved')->avg('rating') ?? 0,
        ];

        // حساب أفضل 5 منتجات بناءً على المبيعات (آخر 30 يوم)
        $storeId = auth()->user()->store->id;
        $startDate = now()->subDays(30)->startOfDay();

        $top5Products = Product::where('products.store_id', $storeId)
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', function ($join) use ($startDate) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->where('orders.created_at', '>=', $startDate)
                    ->where('orders.status', 'delivered');
            })
            ->select(
                'products.*',
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_quantity_sold')
            )
            ->groupBy(
                'products.id',
                'products.product_code',
                'products.name',
                'products.brand',
                'products.description',
                'products.notes',
                'products.full_description',
                'products.price',
                'products.cost_price',
                'products.price_before',
                'products.stock',
                'products.min_stock',
                'products.status',
                'products.image',
                'products.three_d_model',
                'products.three_sixty_images',
                'products.store_id',
                'products.category_id',
                'products.created_at',
                'products.updated_at',
                'products.updated_at',
                'products.warranty',
                'products.sku',
                'products.currency'
            )
            ->orderByDesc('total_quantity_sold')
            ->limit(5)
            ->get();

        $stats['top_products_count'] = $top5Products->count();
        $stats['top_products_total_sold'] = $top5Products->sum('total_quantity_sold');

        // إضافة معلومات المحفظة
        $wallet = Wallet::where('user_id', auth()->user()->id)->first();
        $stats['wallet_balance'] = $wallet ? $wallet->balance : 0;
        $stats['total_earnings'] = $wallet ? $wallet->total_earnings : 0;

        // 1. مبيعات آخر 7 أيام
        $salesLast7Days = Order::where('store_id', $storeId)
            ->where('status', 'delivered')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $salesChartData = [];
        $salesChartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $salesChartLabels[] = now()->subDays($i)->locale('ar')->dayName; // أسماء الأيام بالعربي
            $salesChartData[] = $salesLast7Days->has($date) ? $salesLast7Days[$date]->total_sales : 0;
        }

        // 2. تقييمات المنتجات (تفاصيل)
        $ratingStats = [
            'average' => $stats['average_rating'],
            'count' => $stats['total_reviews'],
            'stars' => [
                5 => Review::whereHas('product', fn($q) => $q->where('store_id', $storeId))->where('rating', 5)->count(),
                4 => Review::whereHas('product', fn($q) => $q->where('store_id', $storeId))->where('rating', 4)->count(),
                3 => Review::whereHas('product', fn($q) => $q->where('store_id', $storeId))->where('rating', 3)->count(),
                2 => Review::whereHas('product', fn($q) => $q->where('store_id', $storeId))->where('rating', 2)->count(),
                1 => Review::whereHas('product', fn($q) => $q->where('store_id', $storeId))->where('rating', 1)->count(),
            ]
        ];

        // 3. أكثر المنتجات مبيعاً (تم جلبها سابقاً في top5Products)
        // سنستخدم المتغير $top5Products

        // 4. المنتجات قليلة المخزون (القائمة)
        $lowStockProducts = Product::where('store_id', $storeId)
            ->where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        // 5. الطلبات في الانتظار (القائمة)
        $latestPendingOrders = Order::where('store_id', $storeId)
            ->where('status', 'pending')
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('vendor.dashboard', compact(
            'stats',
            'top5Products',
            'salesChartLabels',
            'salesChartData',
            'ratingStats',
            'lowStockProducts',
            'latestPendingOrders'
        ));
    }

    public function editStore(): View|string
    {
        $store = auth()->user()->store;
        if (!$store) {
            abort(403, 'عذراً، حسابك لا يمتلك متجراً مرتبطاً به حالياً.');
        }
        return view('vendor.store.edit', compact('store'));
    }

    public function updateStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'commercial_registration' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $store = auth()->user()->store;

        $data = $request->except('logo_path');

        if ($request->hasFile('logo_path')) {
            // Delete old logo if exists
            if ($store->logo_path) {
                \Storage::disk('public')->delete($store->logo_path);
            }
            $data['logo_path'] = $request->file('logo_path')->store('logos', 'public');
        }

        $store->update($data);

        return redirect()->route('vendor.dashboard')->with('success', 'تم تحديث بيانات المتجر بنجاح');
    }

    public function generateToken()
    {
        $user = auth()->user();
        
        // إزالة المفاتيح السابقة (اختياري لضمان وجود مفتاح واحد فقط للتزامن)
        $user->tokens()->where('name', 'desktop-sync-token')->delete();

        // إنشاء مفتاح جديد
        $token = $user->createToken('desktop-sync-token');

        return redirect()->route('vendor.store.edit')
            ->with('api_token', $token->plainTextToken)
            ->with('success', 'تم إصدار مفتاح المزامنة بنجاح. يرجى نسخه من الأسفل قبل مغادرة الصفحة.');
    }
}
