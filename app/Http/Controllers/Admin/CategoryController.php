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
        $categories = Category::latest()->withCount('products')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $data = $request->except('image');

        // Support Arabic slugs or fallback to name if slug is empty
        $data['slug'] = Str::slug($request->name, '-', null);
        if (empty($data['slug'])) {
            $data['slug'] = str_replace(' ', '-', $request->name);
        }

        $data['status'] = $request->status ?? 'active';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->back()->with('success', 'تم إضافة التصنيف بنجاح');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $data = $request->except(['image', '_token', '_method']);

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
