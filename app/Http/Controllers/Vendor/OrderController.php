<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::where('store_id', auth()->user()->store->id)
            ->with(['user', 'orderItems.product']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->latest()->paginate(10);

        return view('vendor.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // التأكد من أن الطلب ينتمي لمتجر البائع
        if ($order->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بعرض هذا الطلب');
        }

        $order->load(['user', 'orderItems.product']);

        return view('vendor.orders.show', compact('order'));
    }

    /**
     * Show the form for creating a new order (vendor creating on behalf of a customer).
     */
    public function create()
    {
        $storeId = auth()->user()->store->id;
        $products = Product::where('store_id', $storeId)->get();
        $users = User::orderBy('name')->limit(200)->get();

        return view('vendor.orders.create', compact('products', 'users'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'shipping_address' => 'required|string',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'nullable|in:cash_on_delivery,credit_card,bank_transfer',
            'notes' => 'nullable|string',
        ]);

        $storeId = auth()->user()->store->id;

        // احسب المجموع وإنشئ الطلب ضمن معاملة
        DB::beginTransaction();
        try {
            $total = 0;
            $items = [];
            foreach ($request->input('products') as $p) {
                $product = Product::find($p['product_id']);
                if (!$product || $product->store_id != $storeId) {
                    throw new \Exception('المنتج غير صالح أو لا ينتمي لمتجرك');
                }
                $qty = (int) $p['quantity'];
                $lineTotal = $product->price * $qty;
                $total += $lineTotal;
                $items[] = [
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $product->price,
                    'total' => $lineTotal,
                ];
            }

            $order = Order::create([
                'order_number' => 'ORD-' . Str::upper(Str::random(8)),
                'user_id' => $request->user_id,
                'store_id' => $storeId,
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method ?? 'cash_on_delivery',
                'payment_status' => 'pending',
                'notes' => $request->notes,
            ]);

            foreach ($items as $it) {
                OrderItem::create(array_merge($it, ['order_id' => $order->id]));
            }

            DB::commit();

            return redirect()->route('vendor.orders.index')->with('success', 'تم إضافة الطلب بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'فشل إنشاء الطلب: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // التأكد من أن الطلب ينتمي لمتجر البائع
        if ($order->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بتعديل هذا الطلب');
        }

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;

        // تحديث التواريخ حسب الحالة
        if ($request->status === 'shipped' && $oldStatus !== 'shipped') {
            $order->shipped_at = now();
        } elseif ($request->status === 'delivered' && $oldStatus !== 'delivered') {
            $order->delivered_at = now();
        }

        $order->save();

        $message = 'تم تحديث حالة الطلب بنجاح';

        return redirect()->back()->with('success', $message);
    }
}
