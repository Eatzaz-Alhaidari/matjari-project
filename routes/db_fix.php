<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

Route::get('/fix-category-images', function () {
    $categories = Category::all();
    $count = 0;

    // Ensure directory exists
    Storage::disk('public')->makeDirectory('categories');

    foreach ($categories as $category) {
        try {
            // Generate a nice placeholder with brand colors (Orange/White)
            $text = urlencode($category->name);
            // using png extension in url
            $url = "https://placehold.co/600x400/ea580c/ffffff.png?text={$text}&font=roboto";

            // Create context to ignore SSL issues if local environment has bad certs
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );

            $contents = file_get_contents($url, false, stream_context_create($arrContextOptions));

            if ($contents) {
                $filename = 'categories/' . $category->id . '_' . time() . '.png';
                Storage::disk('public')->put($filename, $contents);

                $category->image = $filename;
                $category->save();
                $count++;
            }
        } catch (\Exception $e) {
            continue;
        }
    }

    return "Successfully updated images for {$count} categories.";
});
