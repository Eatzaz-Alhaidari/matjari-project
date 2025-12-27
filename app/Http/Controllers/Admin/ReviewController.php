<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product.store']);

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by Store (via Product)
        if ($request->filled('store_id')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('store_id', $request->store_id);
            });
        }

        $reviews = $query->latest()->paginate(10);

        // Summary stats
        $total = Review::count();
        $average = Review::avg('rating') ? round(Review::avg('rating'), 1) : 0;
        $pending = Review::where('status', 'pending')->count();
        $approved = Review::where('status', 'approved')->count();

        $stats = [
            'total' => $total,
            'average_rating' => $average,
            'pending' => $pending,
            'approved' => $approved,
        ];

        // Fetch stores for the filter dropdown
        $stores = \App\Models\Store::select('id', 'name')->orderBy('name')->get();

        return view('admin.reviews.index', compact('reviews', 'stats', 'stores'));
    }
}
