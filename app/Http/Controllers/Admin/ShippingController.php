<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Order;
use App\Services\ShippingService;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    protected $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    /**
     * Display a listing of shippings.
     */
    public function index()
    {
        // Get all shipments with related order and customer info
        $shippings = Shipment::with(['order.user', 'order.store'])->latest()->get();

        // Also get orders that don't have a shipment yet and are in Sana'a
        $pendingOrders = Order::whereDoesntHave('shipment')
            ->where(function ($q) {
                $q->where('shipping_city', 'صنعاء')
                    ->orWhere('shipping_address', 'LIKE', '%صنعاء%');
            })
            ->whereIn('status', ['pending', 'processing'])
            ->get();

        return view('admin.shipping.index', compact('shippings', 'pendingOrders'));
    }

    /**
     * Create a shipment for an order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($order->shipment) {
            return back()->with('error', 'هذا الطلب لديه شحنة بالفعل!');
        }

        $this->shippingService->createShipment($order);

        return back()->with('success', 'تم إنشاء الشحنة بنجاح وتوليد رقم التتبع.');
    }

    /**
     * Update shipment status.
     */
    public function updateStatus(Request $request, Shipment $shipping)
    {
        $request->validate([
            'status' => 'required|in:pending,picked_up,in_transit,delivered,failed',
        ]);

        try {
            $this->shippingService->updateStatus($shipping, $request->status);
            return back()->with('success', 'تم تحديث حالة الشحنة بنجاح!');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء تحديث الحالة: ' . $e->getMessage());
        }
    }
}
