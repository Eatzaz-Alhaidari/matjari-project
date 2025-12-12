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

    public function create() {}

    public function store(Request $request) {}

    public function show(string $id) {}

    public function edit(Store $store): View
    {
        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'commercial_registration' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $store->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']), // الآن هذا السطر سيعمل
            'commercial_registration' => $validated['commercial_registration'],
            'address' => $validated['address'],
            'description' => $validated['description'],
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