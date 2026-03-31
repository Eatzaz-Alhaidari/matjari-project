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
        $categories = Category::whereNull('parent_id') // Start with top-level
            ->where('status', 'active')
            ->with(['children' => function($q) {
                $q->where('status', 'active')->with(['brands:id,name,logo']);
            }, 'brands:id,name,logo'])
            ->select('id', 'name', 'slug', 'image', 'description', 'parent_id')
            ->get();

        $this->formatUrls($categories);

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    private function formatUrls($categories)
    {
        foreach ($categories as $category) {
            $category->image_url = $category->image ? url('api/image/' . $category->image) : null;
            
            if ($category->brands) {
                foreach($category->brands as $brand) {
                    $brand->logo_url = $brand->logo ? url('api/image/' . $brand->logo) : null;
                }
            }

            if ($category->children) {
                $this->formatUrls($category->children);
            }
        }
    }
}
