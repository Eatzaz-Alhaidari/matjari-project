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
        // Require role to be driver
        if ($request->user()->role !== 'driver') {
            return $this->sendError('غير مصرح لك للوصول.', [], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:ready_to_pick,picked_up,delivered',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $order = Order::where('id', $id)
            ->where('driver_id', $request->user()->id)
            ->first();

        if (!$order) {
            return $this->sendError('الطلب غير موجود أو غير مسند إليك.', [], 404);
        }

        $order->status = $request->status;
        
        if ($request->status === 'delivered') {
            $order->delivered_at = now();
            // Automatically mark payment as paid if cash_on_delivery?
            // Depends on business logic, keeping it simple as requested:
        }

        $order->save();

        return $this->sendResponse($order, 'تم تحديث حالة الطلب بنجاح.');
    }
}
