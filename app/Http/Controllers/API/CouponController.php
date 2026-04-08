<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiscountCoupon;

class CouponController extends Controller
{
    /**
     * Get all active coupons for the app to display in the "Offers" card
     */
    public function index()
    {
        $coupons = DiscountCoupon::where('is_active', true)
            ->whereDate('expiry_date', '>=', now())
            ->get(['code', 'type', 'value', 'min_order_amount', 'expiry_date']);

        return response()->json([
            'status' => true,
            'data'   => $coupons
        ]);
    }

    /**
     * Validate a specific coupon code applied by customer in checkout
     */
    public function validateCoupon(Request $request)
    {
        $validated = $request->validate([
            'code'   => 'required|string',
            'amount' => 'required|numeric|min:0' // To check min_order_amount
        ]);

        $coupon = DiscountCoupon::where('code', $validated['code'])
            ->where('is_active', true)
            ->whereDate('expiry_date', '>=', now())
            ->first();

        if (!$coupon) {
            return response()->json([
                'status' => false,
                'message' => 'الكوبون غير صالح أو منتهي الصلاحية'
            ], 404);
        }

        if ($validated['amount'] < $coupon->min_order_amount) {
            return response()->json([
                'status' => false,
                'message' => 'لا يمكنك استخدام هذا الكوبون لطلب أقل من ' . number_format($coupon->min_order_amount, 0) . ' ر.ي'
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'تم تطبيق الخصم بنجاح',
            'data' => [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => (float)$coupon->value,
                'min_order_amount' => (float)$coupon->min_order_amount
            ]
        ]);
    }
}
