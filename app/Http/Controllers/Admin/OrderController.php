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
        $query = Order::with(['user', 'store', 'driver'])->latest();

        // Search Logic
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

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

    public function show(Order $order)
    {
        $order->load(['user', 'store', 'items.product', 'driver']);
        return view('admin.orders.show', compact('order'));
    }
}
