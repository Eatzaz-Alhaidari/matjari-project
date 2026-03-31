<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['store', 'category', 'brand']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stores = Store::active()->get();
        $brands = Brand::orderBy('name')->get();
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.products.create', compact('stores', 'brands', 'categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'nullable|string|max:255|unique:products,product_code',
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'required|string',
            'full_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'price_before' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'store_id' => 'required|exists:stores,id',
            'category_id' => 'required|exists:categories,id',
            'warranty_duration' => 'nullable|integer|min:1',
            'warranty_unit' => 'nullable|in:days,months,years',
            'currency' => 'required|in:YER,SAR,USD',
        ]);

        $data = $request->except('images');

        // Create the product first
        $product = Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $stores = Store::active()->get();
        $brands = Brand::orderBy('name')->get();
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.products.edit', compact('product', 'stores', 'brands', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_code' => 'nullable|string|max:255|unique:products,product_code,' . $product->id,
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'required|string',
            'full_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'price_before' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'store_id' => 'required|exists:stores,id',
            'category_id' => 'required|exists:categories,id',
            'warranty_duration' => 'nullable|integer|min:1',
            'warranty_unit' => 'nullable|in:days,months,years',
            'currency' => 'required|in:YER,SAR,USD',
        ]);

        $data = $request->except('images');
        $data['currency'] = $request->currency; // Force update currency
        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم تعديل المنتج بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete main image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete all secondary images from storage
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }

    public function toggleStatus(Product $product)
    {
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();

        $message = $product->status === 'active' ? 'تم تفعيل المنتج بنجاح' : 'تم تعطيل المنتج بنجاح';

        return redirect()->route('admin.products.index')
            ->with('success', $message);
    }
}
