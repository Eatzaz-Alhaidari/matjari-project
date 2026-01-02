<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Order;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    protected $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    /**
     * Display a listing of shipments.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('super-admin')) {
            return Shipment::with('order')->latest()->get();
        } elseif ($user->hasRole('vendor')) {
            return Shipment::whereHas('order', function ($query) use ($user) {
                $query->where('store_id', $user->store->id);
            })->with('order')->latest()->get();
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    /**
     * Store a newly created shipment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Checking if already has a shipment
        if ($order->shipment) {
            return response()->json(['message' => 'Order already has a shipment'], 422);
        }

        $shipment = $this->shippingService->createShipment($order);

        return response()->json([
            'message' => 'Shipment created successfully',
            'data' => $shipment
        ], 201);
    }

    /**
     * Display the specified shipment.
     */
    public function show($id)
    {
        $shipment = Shipment::with('order.user', 'order.items.product')->find($id);

        if (!$shipment) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }

        $user = Auth::user();

        // Authorization check
        if ($user->hasRole('super-admin')) {
            return $shipment;
        }

        if ($user->hasRole('vendor') && $shipment->order->store_id == $user->store->id) {
            return $shipment;
        }

        if ($shipment->order->user_id == $user->id) {
            return $shipment;
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    /**
     * Update shipment status. (Admin Only)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,picked_up,in_transit,delivered,failed',
        ]);

        $shipment = Shipment::findOrFail($id);

        // Only Admin can update status
        if (!Auth::user()->hasRole('super-admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $updatedShipment = $this->shippingService->updateStatus($shipment, $request->status);
            return response()->json([
                'message' => 'Status updated successfully',
                'data' => $updatedShipment
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
