<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(10);

        // Summary stats similar to vendor view
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

        $products = Product::select('id', 'name')->orderBy('name')->get();

        return view('admin.reviews.index', compact('reviews', 'stats', 'products'));
    }
}
