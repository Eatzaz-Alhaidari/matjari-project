<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['parent', 'brands'])->latest()->withCount('products')->paginate(10);
        $allCategories = Category::active()->whereNull('parent_id')->with('children')->get(); // For parent selection
        $brands = \App\Models\Brand::all();
        return view('admin.categories.index', compact('categories', 'allCategories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|string|in:active,inactive',
            'parent_id' => 'nullable|exists:categories,id',
            'brand_ids' => 'nullable|array',
            'brand_ids.*' => 'exists:brands,id',
        ]);

        $data = $request->except(['image', 'brand_ids']);

        // Support Arabic slugs or fallback to name if slug is empty
        $data['slug'] = Str::slug($request->name, '-', null);
        if (empty($data['slug'])) {
            $data['slug'] = str_replace(' ', '-', $request->name);
        }

        $data['status'] = $request->status ?? 'active';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category = Category::create($data);

        // Sync brands
        if ($request->has('brand_ids')) {
            $category->brands()->sync($request->brand_ids);
        }

        return redirect()->back()->with('success', 'تم إضافة التصنيف بنجاح');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|string|in:active,inactive',
            'parent_id' => 'nullable|exists:categories,id',
            'brand_ids' => 'nullable|array',
            'brand_ids.*' => 'exists:brands,id',
        ]);

        $data = $request->except(['image', 'brand_ids', '_token', '_method']);

        // Support Arabic slugs or fallback to name if slug is empty
        $data['slug'] = Str::slug($request->name, '-', null);
        if (empty($data['slug'])) {
            $data['slug'] = str_replace(' ', '-', $request->name);
        }

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        // Sync brands
        if ($request->has('brand_ids')) {
            $category->brands()->sync($request->brand_ids);
        } else {
            $category->brands()->detach();
        }

        return redirect()->back()->with('success', 'تم تعديل التصنيف بنجاح');
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();

        return redirect()->back()->with('success', 'تم حذف التصنيف بنجاح');
    }
}
