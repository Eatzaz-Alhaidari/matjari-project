<?php

use App\Models\Product;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

// 1. استخراج كل الماركات الفريدة من جدول المنتجات
$uniqueBrands = Product::whereNotNull('brand')
    ->where('brand', '!=', '')
    ->distinct()
    ->pluck('brand');

foreach ($uniqueBrands as $brandName) {
    // 2. إنشاء الماركة إذا لم تكن موجودة
    $brand = Brand::firstOrCreate(['name' => $brandName]);

    // 3. تحديث المنتجات التي تحمل هذا الاسم لترتبط بالـ ID الجديد
    Product::where('brand', $brandName)->update(['brand_id' => $brand->id]);
    
    echo "تمت معالجة الماركة: $brandName\n";
}

echo "اكتملت عملية ترحيل الماركات بنجاح.\n";
