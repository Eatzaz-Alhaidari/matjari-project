<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Get list of active advertisements.
     */
    public function index()
    {
        $advertisements = Advertisement::active()
            ->select(['id', 'title', 'description', 'image', 'start_date', 'end_date', 'target_url', 'view_count']) // Select public fields
            ->latest()
            ->get();

        // Increment views for these ads? 
        // Typically views are incremented when actually seen, better done via a separate 'track-view' endpoint or just assume fetch = view for list.
        // For now, simple fetch.

        return response()->json([
            'success' => true,
            'data' => $advertisements
        ]);
    }
}
