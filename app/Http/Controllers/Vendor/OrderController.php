<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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
