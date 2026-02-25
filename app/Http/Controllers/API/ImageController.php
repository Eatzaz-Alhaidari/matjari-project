<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Serve image from storage with CORS headers.
     * Path should be relative to storage/app/public (e.g., products/image.jpg)
     */
    public function show(Request $request, $path)
    {
        // Decode path if it contains multiple levels (e.g., products/123.jpg)
        $path = str_replace('|', '/', $path);

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('public')->get($path);
        $type = Storage::disk('public')->mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        // Add CORS headers specifically for Flutter Web
        $response->header("Access-Control-Allow-Origin", "*");
        $response->header("Access-Control-Allow-Methods", "GET, OPTIONS");
        $response->header("Access-Control-Allow-Headers", "Content-Type, X-Requested-With, Authorization");

        return $response;
    }
}
