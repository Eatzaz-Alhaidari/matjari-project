<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountCouponController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('discounts');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('code', 'like', "%{$q}%")
                    ->orWhere('title', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $coupons = $query->orderByDesc('created_at')->paginate(20);

        $stats = [
            'total'    => DB::table('discounts')->count(),
            'active'   => DB::table('discounts')->where('status', 'active')->count(),
            'expired'  => DB::table('discounts')->where('status', 'expired')->count(),
            'inactive' => DB::table('discounts')->where('status', 'inactive')->count(),
        ];

        return view('admin.discount-coupons.index', compact('coupons', 'stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:255',
            'code'               => 'required|string|unique:discounts,code|max:100',
            'type'               => 'required|in:percentage,fixed',
            'value'              => 'required|numeric|min:0',
            'min_order_amount'   => 'nullable|numeric|min:0',
            'max_discount_amount'=> 'nullable|numeric|min:0',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'usage_limit'        => 'nullable|integer|min:1',
            'status'             => 'required|in:active,inactive',
        ]);

        $data['min_order_amount'] = $data['min_order_amount'] ?? 0;
        // store_id = 0 for global admin coupons
        $data['store_id'] = 0;
        $data['used_count'] = 0;

        DB::table('discounts')->insert(array_merge($data, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        return redirect()->route('admin.discount-coupons.index')
            ->with('success', 'تم إضافة كوبون الخصم بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:255',
            'code'               => "required|string|max:100|unique:discounts,code,{$id}",
            'type'               => 'required|in:percentage,fixed',
            'value'              => 'required|numeric|min:0',
            'min_order_amount'   => 'nullable|numeric|min:0',
            'max_discount_amount'=> 'nullable|numeric|min:0',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'usage_limit'        => 'nullable|integer|min:1',
            'status'             => 'required|in:active,inactive,expired',
        ]);

        DB::table('discounts')->where('id', $id)->update(array_merge($data, [
            'updated_at' => now(),
        ]));

        return redirect()->route('admin.discount-coupons.index')
            ->with('success', 'تم تعديل الكوبون بنجاح.');
    }

    public function destroy($id)
    {
        DB::table('discounts')->where('id', $id)->delete();
        return redirect()->route('admin.discount-coupons.index')
            ->with('success', 'تم حذف الكوبون بنجاح.');
    }

    public function toggleStatus($id)
    {
        $coupon = DB::table('discounts')->where('id', $id)->first();
        $newStatus = $coupon->status === 'active' ? 'inactive' : 'active';
        DB::table('discounts')->where('id', $id)->update([
            'status'     => $newStatus,
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.discount-coupons.index')
            ->with('success', 'تم تغيير حالة الكوبون بنجاح.');
    }
}
