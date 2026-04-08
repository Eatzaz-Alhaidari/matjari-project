<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserManagementController extends Controller
{
    /**
     * API لبطاقة: إدارة البائعين (جميع البائعين في المنصة)
     */
    public function getVendors(Request $request): JsonResponse
    {
        $status = $request->get('status');
        $query = User::role('vendor')->with('store');

        if ($status) {
            $query->where('status', $status);
        }

        $vendors = $query->latest()->paginate(20);

        return response()->json([
            'label' => 'إدارة البائعين والموردين',
            'data' => $vendors
        ]);
    }

    /**
     * تحديث حالة البائع (نشط/محظور/معلق) من قبل الأدمن
     */
    public function updateVendorStatus(Request $request, $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|string|in:active,banned,pending'
        ]);

        $vendor = User::role('vendor')->findOrFail($id);
        $vendor->update(['status' => $request->status]);

        return response()->json([
            'message' => 'تم تحديث حالة البائع بنجاح',
            'data' => $vendor
        ]);
    }

    /**
     * API لبطاقة: إدارة المتاجر
     */
    public function getStores(Request $request): JsonResponse
    {
        $active = $request->get('active');
        $query = Store::with('user');

        if ($active !== null) {
            $query->where('is_active', (bool)$active);
        }

        $stores = $query->latest()->paginate(15);

        return response()->json([
            'label' => 'إدارة المتاجر والمشاريع',
            'data' => $stores
        ]);
    }

    /**
     * تحديث حالة المتجر (تفعيل/إيقاف)
     */
    public function updateStoreStatus(Request $request, $id): JsonResponse
    {
        $request->validate([
            'is_active' => 'required|boolean'
        ]);

        $store = Store::findOrFail($id);
        $store->update(['is_active' => $request->is_active]);

        return response()->json([
            'message' => 'تم تحديث حالة المتجر بنجاح',
            'data' => $store
        ]);
    }

    /**
     * API لبطاقة: إدارة العملاء (المستخدمين العاديين)
     */
    public function getCustomers(Request $request): JsonResponse
    {
        $query = User::whereDoesntHave('roles')->with('orders');
        
        $status = $request->get('status');
        if($status){
            $query->where('status', $status);
        }

        $customers = $query->latest()->paginate(25);

        return response()->json([
            'label' => 'إدارة وتحليل العملاء',
            'data' => $customers
        ]);
    }
}
