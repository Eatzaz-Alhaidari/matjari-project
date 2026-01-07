<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Get reviews for a specific product.
     *
     * @param int $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($productId)
    {
        // Fetch approved reviews for the product
        $reviews = Review::where('product_id', $productId)
            ->where('status', 'approved')
            ->with('user:id,name') // Only get necessary user fields
            ->latest()
            ->get();

        // Calculate average rating
        $averageRating = $reviews->avg('rating');
        $totalReviews = $reviews->count();

        return response()->json([
            'success' => true,
            'data' => [
                'reviews' => $reviews,
                'average_rating' => $averageRating ? round($averageRating, 1) : 0,
                'total_reviews' => $totalReviews,
            ]
        ]);
    }

    /**
     * Submit a new review.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)//تستسلم البيانات 
    {
        // Validator
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Create review
        // Note: We assume the user is authenticated via Sanctum
        $review = Review::create([
            'user_id' => Auth::id() ?? $request->user_id, // Fallback to request user_id for testing if auth not fully set up yet
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending', // Reviews typically require approval
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully and is pending approval.',
            'data' => $review
        ], 201);
    }
}
