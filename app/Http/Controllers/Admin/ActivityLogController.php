<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activity logs.
     */
    public function index(Request $request)
    {
        $logs = ActivityLog::with('user')
            ->when($request->search, function ($query) use ($request) {
                $query->where('description', 'like', '%' . $request->search . '%')
                    ->orWhere('ip_address', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            })
            ->when($request->action_type, function ($query) use ($request) {
                $query->where('action_type', $request->action_type);
            })
            ->when($request->user_type, function ($query) use ($request) {
                $query->where('user_type', $request->user_type);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.activity-logs.index', compact('logs'));
    }
}
