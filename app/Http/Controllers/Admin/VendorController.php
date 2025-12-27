<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // 1. ابدأ بالاستعلام الأساسي
        $vendorsQuery = User::role('vendor')->with('store');

        // 2. تحقق إذا كان هناك طلب بحث
        if (request()->filled('search')) {
            $searchTerm = request('search');
            // أضف شرط البحث
            $vendorsQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            });
        }

        // 3. قم بتنفيذ الاستعلام مع الترقيم
        // withQueryString() مهم جداً ليحتفظ بكلمة البحث عند التنقل بين الصفحات
        $vendors = $vendorsQuery->paginate(10)->withQueryString();

        return view('admin.vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. التحقق من صحة البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'store_name' => 'required|string|max:255',
            'commercial_registration' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        // 2. معالجة رفع الصورة (إذا وجدت)
        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('vendors', 'public');
        }

        // 3. إنشاء المستخدم (البائع)
        $vendor = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'profile_photo_path' => $photoPath,
        ]);

        // 4. منح دور "بائع" للمستخدم الجديد
        $vendor->assignRole('vendor');

        // 5. إنشاء المتجر وربطه بالبائع
        $vendor->store()->create([
            'name' => $validated['store_name'],
            'slug' => Str::slug($validated['store_name']),
            'commercial_registration' => $validated['commercial_registration'],
            'address' => $validated['address'],
            'is_active' => true,
        ]);

        // 6. إرسال رسالة نجاح والعودة إلى صفحة القائمة
        return redirect()->route('admin.vendors.index')->with('success', 'تم إنشاء البائع الجديد بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $vendor): View
    {
        return view('admin.vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $vendor): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $vendor->id,
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'store_name' => 'required|string|max:255',
            'commercial_registration' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $photoPath = $vendor->profile_photo_path;
        if ($request->hasFile('profile_photo')) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('profile_photo')->store('vendors', 'public');
        }

        $vendor->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'profile_photo_path' => $photoPath,
        ]);

        $vendor->store()->updateOrCreate(
            ['user_id' => $vendor->id],
            [
                'name' => $validated['store_name'],
                'slug' => Str::slug($validated['store_name']),
                'commercial_registration' => $validated['commercial_registration'],
                'address' => $validated['address'],
                'description' => $validated['description'],
            ]
        );

        return redirect()->route('admin.vendors.index')->with('success', 'تم تحديث بيانات البائع بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $vendor): RedirectResponse
    {
        // نتأكد أن المستخدم الذي نحاول حذفه هو بائع
        if ($vendor->hasRole('vendor')) {
            // ملاحظة: بفضل onDelete('cascade') في ملف الـ migration،
            // عند حذف البائع، سيتم حذف متجره تلقائياً.

            // إذا كان لديه صورة، قم بحذفها من الـ storage
            if ($vendor->profile_photo_path) {
                Storage::disk('public')->delete($vendor->profile_photo_path);
            }

            $vendor->delete(); // حذف المستخدم

            return redirect()->route('admin.vendors.index')->with('success', 'تم حذف البائع بنجاح!');
        }

        return redirect()->route('admin.vendors.index')->with('error', 'حدث خطأ أثناء محاولة الحذف.');
    }

    /**
     * Toggle the active status of a vendor's store.
     */
    public function toggleStatus(User $vendor): RedirectResponse
    {
        if ($vendor->hasRole('vendor') && $vendor->store) {
            $vendor->store->is_active = !$vendor->store->is_active;
            $vendor->store->save();
            session()->flash('success', 'تم تغيير حالة المتجر بنجاح!');
        } else {
            session()->flash('error', 'هذا البائع ليس لديه متجر لتغيير حالته.');
        }
        return redirect()->route('admin.vendors.index');
    }

    /**
     * Ban the specified vendor.
     */
    public function ban(Request $request, User $vendor): RedirectResponse
    {
        $request->validate([
            'ban_reason' => 'required|string|max:500',
        ]);

        $vendor->update([
            'status' => 'banned',
            'ban_reason' => $request->ban_reason,
        ]);

        // اختيارياً: تعطيل المتجر عند الحظر
        if ($vendor->store) {
            $vendor->store->update(['is_active' => false]);
        }

        return redirect()->back()->with('success', 'تم حظر البائع بنجاح.');
    }

    /**
     * Activate (Unban) the specified vendor.
     */
    public function activate(User $vendor): RedirectResponse
    {
        $vendor->update([
            'status' => 'active',
            'ban_reason' => null,
        ]);

        return redirect()->back()->with('success', 'تم إعادة تفعيل البائع بنجاح.');
    }
}