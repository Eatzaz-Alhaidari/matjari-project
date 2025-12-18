<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Discount::where('store_id', auth()->user()->store->id)
            ->with(['store']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $discounts = $query->latest()->paginate(10);

        return view('vendor.discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('store_id', auth()->user()->store->id)->active()->get();
        return view('vendor.discounts.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|unique:discounts,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'required|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
            'applicable_products' => 'nullable|array',
            'applicable_products.*' => 'exists:products,id',
        ]);

        $data = $request->except('applicable_products');
        $data['store_id'] = auth()->user()->store->id;

        if ($request->has('applicable_products') && !empty($request->applicable_products)) {
            $data['applicable_products'] = $request->applicable_products;
        }

        Discount::create($data);

        return redirect()->route('vendor.discounts.index')
            ->with('success', 'تم إضافة الخصم بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        // التأكد من أن الخصم ينتمي لمتجر البائع
        if ($discount->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بعرض هذا الخصم');
        }

        $applicableProducts = [];
        if ($discount->applicable_products) {
            $applicableProducts = Product::whereIn('id', $discount->applicable_products)->get();
        }

        return view('vendor.discounts.show', compact('discount', 'applicableProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        // التأكد من أن الخصم ينتمي لمتجر البائع
        if ($discount->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بتعديل هذا الخصم');
        }

        $products = Product::where('store_id', auth()->user()->store->id)->active()->get();
        return view('vendor.discounts.edit', compact('discount', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        // التأكد من أن الخصم ينتمي لمتجر البائع
        if ($discount->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بتعديل هذا الخصم');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|unique:discounts,code,' . $discount->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'required|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
            'applicable_products' => 'nullable|array',
            'applicable_products.*' => 'exists:products,id',
        ]);

        $data = $request->except('applicable_products');

        if ($request->has('applicable_products') && !empty($request->applicable_products)) {
            $data['applicable_products'] = $request->applicable_products;
        } else {
            $data['applicable_products'] = null;
        }

        $discount->update($data);

        return redirect()->route('vendor.discounts.index')
            ->with('success', 'تم تعديل الخصم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        // التأكد من أن الخصم ينتمي لمتجر البائع
        if ($discount->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بحذف هذا الخصم');
        }

        $discount->delete();

        return redirect()->route('vendor.discounts.index')
            ->with('success', 'تم حذف الخصم بنجاح');
    }

    public function toggleStatus(Discount $discount)
    {
        // التأكد من أن الخصم ينتمي لمتجر البائع
        if ($discount->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بتعديل هذا الخصم');
        }

        $discount->status = $discount->status === 'active' ? 'inactive' : 'active';
        $discount->save();

        $message = $discount->status === 'active' ? 'تم تفعيل الخصم بنجاح' : 'تم تعطيل الخصم بنجاح';

        return redirect()->route('vendor.discounts.index')
            ->with('success', $message);
    }
}
