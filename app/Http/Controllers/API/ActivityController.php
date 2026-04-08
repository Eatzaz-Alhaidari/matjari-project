<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerActivity;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Store a new customer activity log dispatched from the mobile app
     */
    public function store(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        
        $validated = $request->validate([
            'activity_type' => 'required|string|max:100',
            'description'   => 'required|string',
            'ip_address'    => 'nullable|ip',
            'device_info'   => 'nullable|string',
        ]);

        $activity = CustomerActivity::create([
            'user_id'       => $user ? $user->id : null,
            'activity_type' => $validated['activity_type'],
            'description'   => $validated['description'],
            'ip_address'    => $request->ip() ?? $validated['ip_address'],
            'device_info'   => $request->header('User-Agent') ?? $validated['device_info'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم تسجيل النشاط بنجاح',
            'data' => $activity
        ], 201);
    }
}
