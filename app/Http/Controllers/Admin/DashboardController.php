<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 1. حساب عدد البائعين
        $vendorCount = User::role('vendor')->count();

        // 2. حساب عدد المتاجر النشطة
        $activeStoresCount = Store::where('is_active', true)->count();
        
        // ##### الكود المضاف #####
        // 3. حساب عدد العملاء (المستخدمين الذين ليس لديهم أي دور)
        $customerCount = User::whereDoesntHave('roles')->count();
        // ##### نهاية الكود المضاف #####

        // 4. إرسال كل هذه البيانات إلى الواجهة
        return view('admin.dashboard', [
            'vendorCount' => $vendorCount,
            'activeStoresCount' => $activeStoresCount,
            'customerCount' => $customerCount, // <-- إرسال المتغير الجديد
        ]);
    }
}