<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::where('status', 'active') // Assuming you want only active categories
            ->select('id', 'name', 'slug', 'image', 'description')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}
