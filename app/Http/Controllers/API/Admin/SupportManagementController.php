<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Advertisement;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SupportManagementController extends Controller
{
    /**
     * API لبطاقة: إدارة الشكاوى والمقترحات
     */
    public function getComplaints(Request $request): JsonResponse
    {
        $status = $request->get('status');
        $query = Complaint::with('user');

        if ($status) {
            $query->where('status', $status);
        }

        $complaints = $query->latest()->paginate(20);

        return response()->json([
            'label' => 'إدارة الشكاوى والمقترحات',
            'data' => $complaints
        ]);
    }

    /**
     * الرد على شكوى معينة وإغلاقها
     */
    public function replyToComplaint(Request $request, $id): JsonResponse
    {
        $request->validate(['reply' => 'required|string']);

        $complaint = Complaint::findOrFail($id);
        $complaint->update([
            'admin_reply' => $request->reply,
            'status' => 'closed'
        ]);

        return response()->json([
            'message' => 'تم الرد على الشكوى وإغلاقها بنجاح',
            'data' => $complaint
        ]);
    }

    /**
     * API لبطاقة: إدارة الإعلانات العامة
     */
    public function getAdvertisements(Request $request): JsonResponse
    {
        $query = Advertisement::with('store');
        $advertisements = $query->latest()->paginate(15);

        return response()->json([
            'label' => 'إدارة الإعلانات والمشاريع',
            'data' => $advertisements
        ]);
    }

    /**
     * API لبطاقة: إدارة الفئات (CRUD)
     */
    public function getCategories(): JsonResponse
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return response()->json([
            'label' => 'إدارة وتصنيف المنتجات',
            'data' => $categories
        ]);
    }

    /**
     * API لبطاقة: أنشطة العملاء
     */
    public function getCustomerActivities(): JsonResponse
    {
        $logs = DB::table('activity_logs')->latest()->paginate(30);
        return response()->json([
            'label' => 'سجل أنشطة وتحركات العملاء',
            'data' => $logs
        ]);
    }
}
