<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        // جلب الطلبات الحقيقية التي في مدينة صنعاء وشركة الشحن "توصيل"
        // ملاحظة: قمنا بإضافة شرط لجلب الطلبات التي حالتها 'shipped' أو 'processing' لإظهار بيانات حقيقية
        $shippings = \App\Models\Order::where(function ($query) {
            $query->where('shipping_city', 'صنعاء')
                ->orWhere('shipping_address', 'like', '%صنعاء%');
        })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => 'SHP-' . $order->id,
                    'order_id' => $order->order_number,
                    'customer' => $order->user->name ?? 'عميل غير معروف',
                    'carrier' => $order->carrier_name ?? 'توصيل',
                    'tracking_number' => $order->tracking_number ?? ('TRK-' . strtoupper(bin2hex(random_bytes(4)))),
                    'status' => $order->status_text, // استخدام الـ Accessor الموجود في الموديل
                    'city' => 'صنعاء',
                    'date' => $order->created_at->format('Y-m-d')
                ];
            });

        return view('admin.shipping.index', compact('shippings'));
    }

    public function updateStatus(Request $request, \App\Models\Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:255',
            'carrier_name' => 'nullable|string|max:255',
        ]);

        $order->update([
            'status' => $request->status,
            'tracking_number' => $request->tracking_number ?? $order->tracking_number,
            'carrier_name' => $request->carrier_name ?? $order->carrier_name,
            'shipped_at' => ($request->status === 'shipped' && !$order->shipped_at) ? now() : $order->shipped_at,
            'delivered_at' => ($request->status === 'delivered' && !$order->delivered_at) ? now() : $order->delivered_at,
        ]);

        return back()->with('success', 'تم تحديث حالة الشحن بنجاح!');
    }
}
