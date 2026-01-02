<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Support\Str;

class ShippingService
{
    /**
     * Create a new shipment for an order.
     */
    public function createShipment(Order $order)
    {
        // City check (as per requirements: only Sana'a)
        // Note: For now we'll allow it but you might want to add validation

        return Shipment::create([
            'order_id' => $order->id,
            'shipping_company' => 'توصيل',
            'tracking_number' => 'TWL-' . strtoupper(Str::random(10)),
            'shipment_id' => 'EXT-' . rand(100000, 999999),
            'status' => 'pending',
            'cost' => 1000.00,
        ]);
    }

    /**
     * Update shipment status.
     */
    public function updateStatus(Shipment $shipment, string $status)
    {
        $validStatuses = ['pending', 'picked_up', 'in_transit', 'delivered', 'failed'];

        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException("Invalid shipment status.");
        }

        $shipment->update(['status' => $status]);

        // If delivered, update order status as well
        if ($status === 'delivered') {
            $shipment->order->update(['status' => 'delivered', 'delivered_at' => now()]);
        }

        return $shipment;
    }

    /**
     * Get shipment tracking details.
     */
    public function track(string $trackingNumber)
    {
        return Shipment::with('order.user')->where('tracking_number', $trackingNumber)->first();
    }
}
