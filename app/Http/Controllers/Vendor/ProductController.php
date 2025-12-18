<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::where('store_id', auth()->user()->store->id)
            ->with(['store', 'category']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $products = $query->latest()->paginate(10);

        return view('vendor.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('vendor.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string',
            'full_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'warranty' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');
        $data['store_id'] = auth()->user()->store->id; // ربط المنتج بمتجر البائع

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('vendor.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // التأكد من أن المنتج ينتمي لمتجر البائع
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بعرض هذا المنتج');
        }

        return view('vendor.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // التأكد من أن المنتج ينتمي لمتجر البائع
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بتعديل هذا المنتج');
        }

        $categories = Category::all();
        return view('vendor.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // التأكد من أن المنتج ينتمي لمتجر البائع
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بتعديل هذا المنتج');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string',
            'full_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'warranty' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('vendor.products.index')
            ->with('success', 'تم تعديل المنتج بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // التأكد من أن المنتج ينتمي لمتجر البائع
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بحذف هذا المنتج');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }

    public function toggleStatus(Product $product)
    {
        // التأكد من أن المنتج ينتمي لمتجر البائع
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بتعديل هذا المنتج');
        }

        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();

        $message = $product->status === 'active' ? 'تم تفعيل المنتج بنجاح' : 'تم تعطيل المنتج بنجاح';

        return redirect()->route('vendor.products.index')
            ->with('success', $message);
    }
}
