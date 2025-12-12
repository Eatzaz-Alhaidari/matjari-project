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

        // 4. Products Count
        $productCount = \App\Models\Product::count();

        // 5. Wallet Total Balance
        $walletTotalBalance = \App\Models\Wallet::sum('balance');

        // 6. Reviews Count
        $reviewCount = \App\Models\Review::count();

        // 7. Complaints Open Count
        $complaintOpenCount = \App\Models\Complaint::where('status', 'open')->count();

        // 8. Notifications Sent Count (Total in DB)
        $notificationCount = \Illuminate\Support\Facades\DB::table('notifications')->count();

        // 9. Financial Reports Count (Just a placeholder logic, maybe total transactions or just static '1' for now as it is a page)
        // Let's count wallets that have earnings as 'reports'
        $financialReportsCount = \App\Models\Wallet::where('total_earnings', '>', 0)->count();


        // 4. إرسال كل هذه البيانات إلى الواجهة
        return view('admin.dashboard', [
            'vendorCount' => $vendorCount,
            'activeStoresCount' => $activeStoresCount,
            'customerCount' => $customerCount,
            'productCount' => $productCount,
            'walletTotalBalance' => $walletTotalBalance,
            'reviewCount' => $reviewCount,
            'complaintOpenCount' => $complaintOpenCount,
            'notificationCount' => $notificationCount,
            'financialReportsCount' => $financialReportsCount,
        ]);
    }
}