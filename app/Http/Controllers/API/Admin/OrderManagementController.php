<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderManagementController extends Controller
{
    /**
     * API لبطاقة: إدارة الطلبات (قائمة جميع طلبات المنصة)
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->get('status');
        $query = Order::with(['user', 'store']);

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(20);

        return response()->json([
            'label' => 'إدارة الطلبات العامة',
            'data' => $orders
        ]);
    }

    /**
     * عرض تفاصيل طلب معين للأدمن
     */
    public function show($id): JsonResponse
    {
        $order = Order::with(['user', 'store', 'items.product'])->findOrFail($id);

        return response()->json([
            'label' => 'تفاصيل الطلب',
            'data' => $order
        ]);
    }

    /**
     * تحديث حالة طلب من قبل الأدمن
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled,returned'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'تم تحديث حالة الطلب بنجاح من قبل الإدارة',
            'data' => $order
        ]);
    }
}
