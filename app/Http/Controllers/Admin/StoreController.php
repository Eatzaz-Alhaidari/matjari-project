<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str; // <-- هذا هو السطر الذي نسيناه

class StoreController extends Controller
{
    public function index(): View
    {
        // 1. ابدأ بالاستعلام الأساسي مع جلب معلومات البائع
        $storesQuery = Store::with('user');

        // 2. تحقق إذا كان هناك طلب بحث
        if (request()->filled('search')) {
            $searchTerm = request('search');
            $storesQuery->where(function ($query) use ($searchTerm) {
                // ابحث في اسم المتجر
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                    // أو ابحث في اسم البائع (عبر العلاقة)
                    ->orWhereHas('user', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        // 3. قم بتنفيذ الاستعلام مع الترقيم والاحتفاظ بكلمة البحث
        $stores = $storesQuery->paginate(10)->withQueryString();

        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
    }

    public function edit(Store $store): View
    {
        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'commercial_registration' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'address' => 'nullable|string|max:255',
            'support_phone' => 'nullable|string|max:20',
            'support_email' => 'nullable|email|max:255',
            'shipping_policy' => 'nullable|string',
            'return_policy' => 'nullable|string',
            'accounting_system' => 'nullable|string|max:255',
        ]);

        $logoPath = $store->logo_path;
        if ($request->hasFile('logo')) {
            if ($logoPath) {
                // Delete old logo
                \Illuminate\Support\Facades\Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $request->file('logo')->store('stores/logos', 'public');
        }

        $coverPath = $store->cover_image_path;
        if ($request->hasFile('cover_image')) {
            if ($coverPath) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($coverPath);
            }
            $coverPath = $request->file('cover_image')->store('stores/covers', 'public');
        }

        $store->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'slogan' => $validated['slogan'],
            'description' => $validated['description'],
            'commercial_registration' => $validated['commercial_registration'],
            'logo_path' => $logoPath,
            'cover_image_path' => $coverPath,
            'address' => $validated['address'],
            'support_phone' => $validated['support_phone'],
            'support_email' => $validated['support_email'],
            'shipping_policy' => $validated['shipping_policy'],
            'return_policy' => $validated['return_policy'],
            'accounting_system' => $validated['accounting_system'],
        ]);

        return redirect()->route('admin.stores.index')->with('success', 'تم تحديث بيانات المتجر بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store): RedirectResponse
    {
        // حذف المتجر سيؤدي إلى مشكلة إذا كان البائع ما زال موجوداً
        // الطريقة الأفضل هي حذف البائع، والذي سيقوم بحذف المتجر تلقائياً
        // لكن، إذا أردنا حذف المتجر فقط، يمكننا فعل ذلك

        // أولاً، قم بحذف أي ملفات مرتبطة بالمتجر (مثل الشعار)
        // if ($store->logo_path) {
        //     Storage::disk('public')->delete($store->logo_path);
        // }

        $store->delete();

        return redirect()->route('admin.stores.index')->with('success', 'تم حذف المتجر بنجاح!');
    }

    public function toggleStatus(Store $store): RedirectResponse
    {
        $store->is_active = !$store->is_active;
        $store->save();
        return redirect()->route('admin.stores.index')->with('success', 'تم تغيير حالة المتجر بنجاح!');
    }
}