<?php

$source = 'C:/Users/MY_World/.gemini/antigravity/brain/272e1631-3c3e-4618-a431-101f53bde14e/media__1775072776995.png';
$destLogo = __DIR__ . '/assets/brand/logo.png';
$destFav = __DIR__ . '/assets/brand/favicon.png';

echo "--- Logo Synchronization Utility ---\n";

if (!file_exists(dirname($destLogo))) {
    mkdir(dirname($destLogo), 0777, true);
    echo "[+] Created directory: assets/brand/\n";
}

if (file_exists($source)) {
    // تحميل الصورة (يدعم PNG و JPEG)
    $img = @imagecreatefromstring(file_get_contents($source));
    if ($img) {
        // تفعيل الشفافية
        imagealphablending($img, false);
        imagesavealpha($img, true);

        // إزالة اللون الأبيض (أو القريب جداً من الأبيض)
        $white = imagecolorallocatealpha($img, 255, 255, 255, 127);
        
        // البحث عن كل بكسل أبيض وتبديله بشفاف
        for ($x = 0; $x < imagesx($img); $x++) {
            for ($y = 0; $y < imagesy($img); $y++) {
                $color = imagecolorat($img, $x, $y);
                $rgba = imagecolorsforindex($img, $color);
                
                // إذا كان اللون قريباً جداً من الأبيض (لنتجنب الحواف البيضاء)
                if ($rgba['red'] > 245 && $rgba['green'] > 245 && $rgba['blue'] > 245) {
                    imagesetpixel($img, $x, $y, $white);
                }
            }
        }

        // حفظ الصورة النهائية
        imagepng($img, $destLogo);
        imagepng($img, $destFav);
        imagedestroy($img);
        
        echo "[SUCCESS] New transparent logo created: assets/brand/logo.png\n";
    } else {
        echo "[ERROR] Could not process image. Is GD extension installed?\n";
    }
} else {
    echo "[ERROR] Source image not found at: $source\n";
}
