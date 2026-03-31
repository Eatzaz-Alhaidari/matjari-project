<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Encoders\PngEncoder;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->withCount('products')->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('name');

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $image = Image::read($file);
            $image->scale(height: 50);
            $encoded = $image->encode(new PngEncoder());
            $filename = 'brands/' . hexdec(uniqid()) . '.png';
            Storage::disk('public')->put($filename, (string) $encoded);
            $data['logo'] = $filename;
        }

        Brand::create($data);

        return redirect()->back()->with('success', 'تم إضافة الماركة بنجاح');
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('name');

        if ($request->hasFile('logo')) {
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $file = $request->file('logo');
            $image = Image::read($file);
            $image->scale(height: 50);
            $encoded = $image->encode(new PngEncoder());
            $filename = 'brands/' . hexdec(uniqid()) . '.png';
            Storage::disk('public')->put($filename, (string) $encoded);
            $data['logo'] = $filename;
        }

        $brand->update($data);

        return redirect()->back()->with('success', 'تم تعديل الماركة بنجاح');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }
        $brand->delete();

        return redirect()->back()->with('success', 'تم حذف الماركة بنجاح');
    }
}
