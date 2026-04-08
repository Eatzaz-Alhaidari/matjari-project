<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderManagementController extends Controller
{
    /**
     * API لبطاقة: إدارة الطلبات (قائمة طلبات المتجر الخاص)
     */
    public function index(Request $request): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $status = $request->get('status');

        $query = Order::where('store_id', $storeId)->with('user');

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(15);

        return response()->json([
            'label' => 'إدارة طلبات المتجر',
            'data' => $orders
        ]);
    }

    /**
     * عرض تفاصيل طلب بائع معين
     */
    public function show($id): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $order = Order::where('store_id', $storeId)->with(['user', 'items.product'])->findOrFail($id);

        return response()->json([
            'label' => 'تفاصيل الطلب للبائع',
            'data' => $order
        ]);
    }

    /**
     * تحديث حالة الطلب من قبل البائع (تجهيز/شحن)
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|string|in:processing,shipped'
        ]);

        $storeId = auth()->user()->store->id;
        $order = Order::where('store_id', $storeId)->findOrFail($id);
        
        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'تم تحديث حالة الطلب بنجاح من قبل البائع',
            'data' => $order
        ]);
    }
}
