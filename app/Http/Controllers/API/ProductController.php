<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     * Use query parameters for filtering: ?category_id=1&search=xyz
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Product::with(['category:id,name', 'store:id,name']) // Eager load category and store names
            ->where('status', 'active'); // Only active products

        // Filter by Category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search by Name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Get paginated results
        $products = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)//
    {
        $product = Product::with(['category', 'store', 'reviews.user:id,name'])
            ->where('status', 'active')
            ->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);//غير موجودة
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }
}
