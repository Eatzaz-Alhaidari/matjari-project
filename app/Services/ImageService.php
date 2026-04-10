<?php

namespace App\Services;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageService
{
    /**
     * Processing and saving images with standard sizes.
     * 
     * @param UploadedFile $file
     * @param string $folder Storage folder
     * @param string $type ('product', 'advertisement', 'logo')
     * @return string Relative path of the saved image
     */
    public static function processAndStore(UploadedFile $file, string $folder, string $type = 'product'): string
    {
        try {
            // Define dimensions based on type
            $dimensions = match ($type) {
                'advertisement' => ['width' => 1200, 'height' => 500], // Wide Banner
                'logo', 'category' => ['width' => 512, 'height' => 512], // Square Icon
                default => ['width' => 800, 'height' => 800], // Standard Product
            };

            $filename = uniqid() . '.jpg';
            $path = $folder . '/' . $filename;

            // Read image
            $image = Image::read($file);

            // Process based on type
            if ($type === 'advertisement') {
                // Cover / Crop for banners
                $image->cover($dimensions['width'], $dimensions['height']);
            } else {
                // Fit for products/logos to maintain aspect ratio and avoid stretching
                $image->scaleDown(width: $dimensions['width'], height: $dimensions['height']);
            }

            // Save as high quality JPG (90)
            $encoded = $image->encodeByMediaType('image/jpeg', quality: 90);

            // Store in the specified disk (public)
            Storage::disk('public')->put($path, (string) $encoded);

            return $path;
        } catch (\Exception $e) {
            // Fallback: If GD or Imagick driver is missing, store the original file
            // to prevent the application from crashing.
            return $file->store($folder, 'public');
        }
    }
}
