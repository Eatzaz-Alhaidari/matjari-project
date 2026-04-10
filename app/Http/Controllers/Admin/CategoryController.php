<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::whereNull('parent_id')
            ->with(['children.children']);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $categories = $query->latest()->paginate(10);
            
        $allCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.index', compact('categories', 'allCategories'));
    }

    public function toggleStatus(Category $category)
    {
        $category->status = $category->status === 'active' ? 'inactive' : 'active';
        $category->save();

        return redirect()->back()->with('success', 'تم تحديث حالة التصنيف بنجاح');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable|string|in:active,inactive',
            'parent_id' => 'nullable|exists:categories,id',
            'is_brand' => 'nullable|boolean',
            'is_popular' => 'nullable|boolean',
            'brand_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
            // Subcategories arrays
            'sub_names.*' => 'nullable|string|max:255',
            
            // Brands arrays
            'brand_names.*' => 'nullable|string|max:255',
        ]);

        $data = $request->except(['image', 'brand_logo', 'banner', 'icon', 'is_popular', 'sub_names', 'sub_icons', 'brand_names', 'brand_logos']);

        // Support Arabic slugs
        $data['slug'] = Str::slug($request->name, '-', null);
        if (empty($data['slug'])) {
            $data['slug'] = str_replace(' ', '-', $request->name);
        }

        $data['status'] = $request->status ?? 'active';
        $data['is_brand'] = $request->has('is_brand');
        $data['is_popular'] = $request->has('is_popular');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('categories/banners', 'public');
        }

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('categories/icons', 'public');
        }

        if ($request->hasFile('brand_logo')) {
            $data['brand_logo'] = $request->file('brand_logo')->store('brands', 'public');
        }

        // 1. Create the Main Category
        $parentCategory = Category::create($data);

        // 2. Create Subcategories
        if ($request->has('sub_names')) {
            foreach ($request->sub_names as $index => $subName) {
                if (empty($subName)) continue;

                $subData = [
                    'name' => $subName,
                    'parent_id' => $parentCategory->id,
                    'status' => 'active',
                    'is_brand' => false,
                ];

                $slugBase = Str::slug($subName, '-', null) ?: str_replace(' ', '-', $subName);
                $subData['slug'] = $slugBase . '-' . rand(100, 9999);

                Category::create($subData);
            }
        }

        // 3. Create Brands
        if ($request->has('brand_names')) {
            foreach ($request->brand_names as $index => $brandName) {
                if (empty($brandName)) continue;

                $brandData = [
                    'name' => $brandName,
                    'parent_id' => $parentCategory->id,
                    'status' => 'active',
                    'is_brand' => true,
                ];

                $slugBase = Str::slug($brandName, '-', null) ?: str_replace(' ', '-', $brandName);
                $brandData['slug'] = $slugBase . '-' . rand(100, 9999);

                Category::create($brandData);
            }
        }

        return redirect()->back()->with('success', 'تم إضافة التصنيف والمحتويات المرتبطة بنجاح');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            
            // Subcategories
            'sub_ids.*' => 'nullable|exists:categories,id',
            'sub_names.*' => 'nullable|string|max:255',
            
            // Brands
            'brand_ids.*' => 'nullable|exists:categories,id',
            'brand_names.*' => 'nullable|string|max:255',
        ]);

        // 1. Update Root Category
        $category->name = $request->name;
        $category->status = $request->status;
        $category->slug = Str::slug($request->name, '-', null) ?: str_replace(' ', '-', $request->name);
        
        if ($request->hasFile('image')) {
            if ($category->image) Storage::disk('public')->delete($category->image);
            $category->image = $request->file('image')->store('categories', 'public');
        }
        $category->save();

        // 2. Sync Subcategories
        $currentSubIds = $category->children()->where('is_brand', false)->pluck('id')->toArray();
        $submittedSubIds = array_filter($request->sub_ids ?? []);
        
        // Delete removed subs
        $toDeleteSubs = array_diff($currentSubIds, $submittedSubIds);
        Category::whereIn('id', $toDeleteSubs)->delete();

        if ($request->has('sub_names')) {
            foreach ($request->sub_names as $index => $subName) {
                if (empty($subName)) continue;
                
                $subId = $request->sub_ids[$index] ?? null;
                $sub = $subId ? Category::find($subId) : new Category();
                
                $sub->name = $subName;
                $sub->parent_id = $category->id;
                $sub->is_brand = false;
                $sub->status = $category->status; // Inherit status or keep separate? Usually same.
                $slugBase = Str::slug($subName, '-', null) ?: str_replace(' ', '-', $subName);
                $sub->slug = $slugBase . '-' . rand(100, 9999);

                $sub->save();
            }
        }

        // 3. Sync Brands
        $currentBrandIds = $category->children()->where('is_brand', true)->pluck('id')->toArray();
        $submittedBrandIds = array_filter($request->brand_ids ?? []);
        
        // Delete removed brands
        $toDeleteBrands = array_diff($currentBrandIds, $submittedBrandIds);
        Category::whereIn('id', $toDeleteBrands)->delete();

        if ($request->has('brand_names')) {
            foreach ($request->brand_names as $index => $brandName) {
                if (empty($brandName)) continue;
                
                $brandId = $request->brand_ids[$index] ?? null;
                $brand = $brandId ? Category::find($brandId) : new Category();
                
                $brand->name = $brandName;
                $brand->parent_id = $category->id;
                $brand->is_brand = true;
                $brand->status = $category->status;
                $slugBase = Str::slug($brandName, '-', null) ?: str_replace(' ', '-', $brandName);
                $brand->slug = $slugBase . '-' . rand(100, 9999);

                $brand->save();
            }
        }

        return redirect()->back()->with('success', 'تم تحديث التصنيف وجميع أفرعه بنجاح');
    }

    public function destroy(Category $category)
    {
        // Recursively delete children images
        foreach($category->children as $child) {
            // Children no longer have images we manage this way
        }
        
        if ($category->image) Storage::disk('public')->delete($category->image);
        $category->delete();

        return redirect()->back()->with('success', 'تم حذف التصنيف وجميع محتوياته بنجاح');
    }
}
