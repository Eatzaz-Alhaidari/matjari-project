<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
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
        $query = Product::where('store_id', auth()->user()->store->id)
            ->with(['store', 'category', 'sizes', 'colors', 'brand']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%")
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
        $brands = Category::where('is_brand', true)->orderBy('name')->get();
        $categories = Category::with('children')->whereNull('parent_id')->where('is_brand', false)->get();
        return view('vendor.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
        $data['store_id'] = auth()->user()->store->id;

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

        $brands = Category::where('is_brand', true)->orderBy('name')->get();
        $categories = Category::with('children')->whereNull('parent_id')->where('is_brand', false)->get();
        return view('vendor.products.edit', compact('product', 'categories', 'brands'));
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

        \Illuminate\Support\Facades\Log::info('Product Update Request Data:', $request->all());

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
            'warranty_duration' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,id',
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
        $data['currency'] = $request->currency; // Force update currency

        \Illuminate\Support\Facades\Log::info('Vendor Product Update - Final Data:', $data);

        $updated = $product->update($data);
        \Illuminate\Support\Facades\Log::info('Vendor Product Update - Result:', ['updated' => $updated, 'new_currency' => $product->fresh()->currency]);

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

        // Delete all secondary images from storage
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
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
