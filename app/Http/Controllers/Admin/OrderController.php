<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'store'])->latest();

        // Tabs Logic
        $tab = $request->get('tab', 'all');

        if ($tab == 'pending') {
            $query->where('status', 'pending');
        } elseif ($tab == 'delayed') {
            // Delayed: processing more than 3 days
            $query->where('status', 'processing')
                ->where('created_at', '<', Carbon::now()->subDays(3));
        } elseif ($tab == 'problem') {
            // Problem/Stuck: has a problem reason explicitly set
            $query->whereNotNull('problem_reason')->where('problem_reason', '!=', '');
        }

        $orders = $query->paginate(15);

        // Counts for tabs
        $pendingCount = Order::where('status', 'pending')->count();
        $delayedCount = Order::where('status', 'processing')->where('created_at', '<', Carbon::now()->subDays(3))->count();
        $problemCount = Order::whereNotNull('problem_reason')->where('problem_reason', '!=', '')->count();

        return view('admin.orders.index', compact('orders', 'pendingCount', 'delayedCount', 'problemCount', 'tab'));
    }
}
