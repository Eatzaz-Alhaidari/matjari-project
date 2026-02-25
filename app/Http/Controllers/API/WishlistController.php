<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Auth::user()->wishlist()->with('product')->get();
        return response()->json([
            'success' => true,
            'data' => $wishlist
        ]);
    }

    public function toggle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $productId = $request->product_id;

        $wishlistItem = $user->wishlist()->where('product_id', $productId)->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist',
                'status' => 'removed'
            ]);
        } else {
            $user->wishlist()->create(['product_id' => $productId]);
            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist',
                'status' => 'added'
            ]);
        }
    }
}
