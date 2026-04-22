<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class DriverController extends BaseController
{
    /**
     * Get all orders assigned to the currently authenticated driver.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        // Require role to be driver (or admin)
        if ($request->user()->role !== 'driver') {
            return $this->sendError('غير مصرح لك للوصول.', [], 403);
        }

        $orders = Order::where('driver_id', $request->user()->id)
            ->with(['orderItems.product', 'store', 'user']) // eager load relevant relationships
            ->orderBy('id', 'desc')
            ->get();

        \Log::info('Driver orders fetched', [
            'driver_id' => $request->user()->id,
            'order_count' => $orders->count(),
            'orders' => $orders->pluck('id')
        ]);

        return $this->sendResponse($orders, 'تم جلب طلبات المندوب بنجاح.');
    }

    /**
     * Update the status of a specific order assigned to the driver.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        \Log::info('Order status update attempt', [
            'order_id' => $id,
            'new_status' => $request->status,
            'driver_id' => $request->user()->id
        ]);

        // Require role to be driver
        if ($request->user()->role !== 'driver') {
            return $this->sendError('غير مصرح لك للوصول.', [], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:ready_to_pick,picked_up,delivered,shipped,pending',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed for status update', $validator->errors()->toArray());
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $order = Order::where('id', $id)
            ->where('driver_id', $request->user()->id)
            ->first();

        if (!$order) {
            \Log::warning('Order not found or not assigned to driver', ['order_id' => $id, 'driver_id' => $request->user()->id]);
            return $this->sendError('الطلب غير موجود أو غير مسند إليك.', [], 404);
        }

        $order->status = $request->status;
        
        if ($request->status === 'delivered') {
            $order->delivered_at = now();
        }

        $order->save();

        \Log::info('Order status updated successfully', ['order_id' => $id, 'status' => $request->status]);

        return $this->sendResponse($order, 'تم تحديث حالة الطلب بنجاح.');
    }
}
