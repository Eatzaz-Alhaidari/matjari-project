<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderReturnController extends Controller
{
    /**
     * استقبال طلب الإرجاع والتعويض من تطبيق الموبايل
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id'   => 'required|exists:orders,id',
            'product_id' => 'nullable|exists:products,id',
            'quantity'   => 'nullable|integer|min:1',
            'reason'     => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // الحصول على المستخدم الحالي (إجباري)
        $userId = Auth::id();

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً.'
            ], 401);
        }

        // التحقق من أن الطلب يخص المستخدم
        $order = Order::find($request->order_id);
        if ($order->user_id != $userId) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح لك بإرجاع هذا الطلب.'
            ], 403);
        }

        try {
            $orderReturn = OrderReturn::create([
                'order_id'     => $request->order_id,
                'product_id'   => $request->product_id,
                'quantity'     => $request->quantity ?? 1,
                'user_id'      => $userId,
                'reason'       => $request->reason,
                'status'       => 'pending',
                'is_restocked' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم استلام طلب الإرجاع بنجاح، سيتم مراجعته من قبل الإدارة.',
                'data'    => $orderReturn
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تقديم طلب الإرجاع: ' . $e->getMessage()
            ], 500);
        }
    }
}
