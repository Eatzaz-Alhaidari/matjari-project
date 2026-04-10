<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ReviewController extends BaseController
{
    /**
     * Store product review.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeProductReview(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $review = Review::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending',
        ]);

        return $this->sendResponse($review, 'تم استقبال تقييم المنتج بنجاح', 201);
    }

    /**
     * Store store review.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeStoreReview(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'store_id' => 'required|exists:stores,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $review = Review::create([
            'user_id' => $request->user_id,
            'store_id' => $request->store_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending',
        ]);

        return $this->sendResponse($review, 'تم استقبال تقييم المتجر بنجاح', 201);
    }
}
