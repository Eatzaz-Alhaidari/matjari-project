<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderReturn;
use Illuminate\Http\Request;

class OrderReturnController extends Controller
{
    public function index()
    {
        $returns = OrderReturn::with(['order', 'user', 'product'])->latest()->paginate(10);
        return view('admin.returns.index', compact('returns'));
    }

    public function updateStatus(Request $request, OrderReturn $returnOrder)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,refunded',
            'admin_response' => 'nullable|string',
            'refund_amount' => 'nullable|numeric|min:0',
        ]);

        $returnOrder->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response,
            'refund_amount' => $request->refund_amount,
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة طلب الإرجاع بنجاح.');
    }

    public function restock(OrderReturn $returnOrder)
    {
        if ($returnOrder->is_restocked) {
            return redirect()->back()->with('error', 'تمت إعادة هذا المنتج للمخزون مسبقاً.');
        }

        if (!$returnOrder->product_id) {
            return redirect()->back()->with('error', 'لا يوجد منتج مرتبط بهذا الطلب لإعادته للمخزون.');
        }

        $product = $returnOrder->product;
        $product->increment('stock', $returnOrder->quantity);

        $returnOrder->update(['is_restocked' => true]);

        return redirect()->back()->with('success', 'تمت إعادة المنتج للمخزون بنجاح.');
    }
}
