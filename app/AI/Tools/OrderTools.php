<?php

namespace App\AI\Tools;

use App\Models\Order;
use LaravelAIAgent\Attributes\AsAITool;
use Carbon\Carbon;

class OrderTools
{
    #[AsAITool(description: 'جلب إجمالي مبيعات المتجر لليوم الحالي')]
    public function getTodaySalesSummary(): string
    {
        $user = auth()->user();
        if (!$user || !$user->store) {
            return "عذراً، لم يتم العثور على متجر مرتبط بحسابك.";
        }

        $todaySales = Order::where('store_id', $user->store->id)
            ->where('status', 'delivered')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_amount');

        if ($todaySales == 0) {
            return "لم يتم تسجيل أي مبيعات مكتملة اليوم حتى الآن.";
        }

        return "إجمالي مبيعاتك اليوم هو: " . number_format($todaySales, 2) . " ريال.";
    }

    #[AsAITool(description: 'جلب ملخص بالطلبات الجديدة التي بانتظار المراجعة')]
    public function getPendingOrdersSummary(): string
    {
        $user = auth()->user();
        if (!$user || !$user->store) {
            return "عذراً، لم يتم العثور على متجر مرتبط بحسابك.";
        }

        $pendingOrders = Order::where('store_id', $user->store->id)
            ->where('status', 'pending')
            ->with('user')
            ->get();

        if ($pendingOrders->isEmpty()) {
            return "لا توجد طلبات جديدة بانتظار المراجعة حالياً.";
        }

        $count = $pendingOrders->count();
        $response = "لديك " . $count . " طلب(طلبات) جديدة بانتظار المراجعة:\n";
        
        foreach ($pendingOrders as $order) {
            $customerName = $order->user ? $order->user->name : 'عميل غير معروف';
            $response .= "- رقم الطلب: " . $order->order_number . " | العميل: " . $customerName . " | المبلغ: " . number_format($order->total_amount, 2) . " ريال.\n";
        }

        return $response;
    }
}
