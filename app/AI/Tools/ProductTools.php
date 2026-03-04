<?php

namespace App\AI\Tools;

use App\Models\Product;
use LaravelAIAgent\Attributes\AsAITool;

class ProductTools
{
    #[AsAITool(description: 'جلب إجمالي عدد المنتجات المتوفرة في المتجر حالياً')]
    public function getTotalProductsCount(): string
    {
        $user = auth()->user();

        if (!$user) {
            return "عذراً، يجب تسجيل الدخول لمعرفة عدد المنتجات.";
        }

        $store = $user->store;

        if (!$store) {
            return "عذراً، لم يتم العثور على متجر مرتبط بحسابك.";
        }

        $count = Product::where('store_id', $store->id)->count();
        return "يوجد حالياً " . $count . " منتج(منتجات) في متجرك.";
    }
}