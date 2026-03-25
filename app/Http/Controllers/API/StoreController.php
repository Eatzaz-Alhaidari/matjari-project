<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Http\Requests\StoreRequest;
use App\Http\Resources\StoreResource;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        return StoreResource::collection(Store::all());
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        
        $store = Store::create($validated);
        
        return new StoreResource($store);
    }

    public function show($id)
    {
        $store = Store::findOrFail($id);
        return new StoreResource($store);
    }

    public function update(StoreRequest $request, $id)
    {
        $store = Store::findOrFail($id);
        
        if ($store->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $store->update($request->validated());
        
        return new StoreResource($store);
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        
        if ($store->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $store->delete();
        
        return response()->json(['message' => 'Store deleted successfully']);
    }
}
