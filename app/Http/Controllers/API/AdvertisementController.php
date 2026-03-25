<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Store;
use App\Http\Requests\AdvertisementRequest;
use App\Http\Resources\AdvertisementResource;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index($storeId)
    {
        $store = Store::findOrFail($storeId);
        return AdvertisementResource::collection($store->advertisements);
    }

    public function store(AdvertisementRequest $request, $storeId)
    {
        $store = Store::findOrFail($storeId);
        
        if ($store->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validated();
        $validated['store_id'] = $store->id;
        
        $advertisement = Advertisement::create($validated);
        
        return new AdvertisementResource($advertisement);
    }
}
