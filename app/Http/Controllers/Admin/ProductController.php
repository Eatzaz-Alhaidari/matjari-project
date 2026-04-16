<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

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
        // Get all unique categories marked as brands
        $brands = Category::where('is_brand', true)
            ->select('name', \Illuminate\Support\Facades\DB::raw('MIN(id) as id'))
            ->groupBy('name')
            ->orderBy('name')
            ->get();
        $categories = Category::with('children')->whereNull('parent_id')->where('is_brand', false)->get();
        return view('admin.products.create', compact('stores', 'brands', 'categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'nullable|string|max:255|unique:products,product_code',
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:categories,id',
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
            'warranty_duration' => 'nullable|integer|min:0',
            'size' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'currency' => 'required|in:YER,SAR,USD',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'three_d_model' => 'nullable|file|max:20480', // 20MB max
            'three_sixty_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['images', 'sizes', 'colors', 'image', 'three_d_model', 'three_sixty_images']);
        $data['warranty_unit'] = 'days';

        if ($request->hasFile('image')) {
            $data['image'] = ImageService::processAndStore($request->file('image'), 'products', 'product');
        }

        if ($request->hasFile('three_d_model')) {
            $data['three_d_model'] = $request->file('three_d_model')->store('products/3d', 'public');
        }

        if ($request->hasFile('three_sixty_images')) {
            $paths = [];
            foreach ($request->file('three_sixty_images') as $file) {
                $paths[] = $file->store('products/360', 'public');
            }
            $data['three_sixty_images'] = $paths;
        }

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = ImageService::processAndStore($file, 'products/gallery', 'product');
                $product->images()->create(['image_path' => $path]);
            }
        }

        if ($request->has('sizes')) {
            foreach ($request->sizes as $sizeName) {
                if ($sizeName) {
                    $product->sizes()->create(['name' => $sizeName]);
                }
            }
        }

        if ($request->has('colors')) {
            foreach ($request->colors as $index => $colorData) {
                if (!empty($colorData['name'])) {
                    $colorImagePath = null;
                    if ($request->hasFile("colors.$index.image")) {
                        $colorImagePath = $request->file("colors.$index.image")->store('products/colors', 'public');
                    }
                    $product->colors()->create([
                        'name' => $colorData['name'],
                        'image_path' => $colorImagePath
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $stores = Store::active()->get();
        $brands = Category::where('is_brand', true)
            ->select('name', \Illuminate\Support\Facades\DB::raw('MIN(id) as id'))
            ->groupBy('name')
            ->orderBy('name')
            ->get();
        $categories = Category::with('children')->whereNull('parent_id')->where('is_brand', false)->get();
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
            'brand_id' => 'nullable|exists:categories,id',
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
            'warranty_duration' => 'nullable|integer|min:0',
            'size' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'currency' => 'required|in:YER,SAR,USD',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'three_d_model' => 'nullable|file|max:20480',
            'three_sixty_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['images', 'sizes', 'colors', 'image', 'three_d_model', 'three_sixty_images']);
        $data['warranty_unit'] = 'days';
        $data['currency'] = $request->currency;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = ImageService::processAndStore($request->file('image'), 'products', 'product');
        }

        if ($request->hasFile('three_d_model')) {
            if ($product->three_d_model) {
                Storage::disk('public')->delete($product->three_d_model);
            }
            $data['three_d_model'] = $request->file('three_d_model')->store('products/3d', 'public');
        }

        if ($request->hasFile('three_sixty_images')) {
            if ($product->three_sixty_images) {
                foreach ($product->three_sixty_images as $oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $paths = [];
            foreach ($request->file('three_sixty_images') as $file) {
                $paths[] = $file->store('products/360', 'public');
            }
            $data['three_sixty_images'] = $paths;
        }

        $product->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = ImageService::processAndStore($file, 'products/gallery', 'product');
                $product->images()->create(['image_path' => $path]);
            }
        }

        if ($request->has('sizes')) {
            $product->sizes()->delete();
            foreach ($request->sizes as $sizeName) {
                if ($sizeName) {
                    $product->sizes()->create(['name' => $sizeName]);
                }
            }
        }

        if ($request->has('colors')) {
            foreach ($request->colors as $index => $colorData) {
                if (!empty($colorData['name'])) {
                    $colorImagePath = null;
                    if ($request->hasFile("colors.$index.image")) {
                        $colorImagePath = $request->file("colors.$index.image")->store('products/colors', 'public');
                    } elseif (!empty($colorData['existing_image'])) {
                        $colorImagePath = $colorData['existing_image'];
                    }

                    $product->colors()->updateOrCreate(
                        ['name' => $colorData['name']],
                        ['image_path' => $colorImagePath]
                    );
                }
            }
            $newNames = array_column($request->colors, 'name');
            $product->colors()->whereNotIn('name', $newNames)->delete();
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'تم تعديل المنتج بنجاح');
    }

    public function toggleStatus(Product $product)
    {
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();

        $message = $product->status === 'active' ? 'تم تفعيل المنتج بنجاح' : 'تم تعطيل المنتج بنجاح';

        return redirect()->route('admin.products.index')
            ->with('success', $message);
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
}
