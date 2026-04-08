<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Discount;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EngagementController extends Controller
{
    /**
     * API لبطاقة: إدارة الإعلانات الخاصة بالمتجر
     */
    public function getAdvertisements(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $advertisements = Advertisement::where('store_id', $storeId)->latest()->paginate(10);
        
        return response()->json([
            'label' => 'إدارة الإعلانات الترويجية',
            'data' => $advertisements
        ]);
    }

    /**
     * API لبطاقة: إدارة الخصومات والكوبونات الخاصة
     */
    public function getDiscounts(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $discounts = Discount::where('store_id', $storeId)->latest()->paginate(10);

        return response()->json([
            'label' => 'إدارة كوبونات الخصم والجوائز',
            'data' => $discounts
        ]);
    }

    /**
     * API لبطاقة: إدارة التقييمات وردود العملاء
     */
    public function getReviews(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $reviews = Review::whereHas('product', function ($q) use ($storeId) {
            $q->where('store_id', $storeId);
        })->with('product', 'user')->latest()->paginate(15);

        return response()->json([
            'label' => 'إحصائيات وردود العملاء',
            'data' => $reviews
        ]);
    }

    /**
     * الرد على تقييم عميل من قبل البائع
     */
    public function replyToReview(Request $request, $id): JsonResponse
    {
        $request->validate(['reply' => 'required|string']);

        $storeId = auth()->user()->store->id;
        $review = Review::whereHas('product', function ($q) use ($storeId) {
            $q->where('store_id', $storeId);
        })->findOrFail($id);

        $review->update(['vendor_reply' => $request->reply]);

        return response()->json([
            'message' => 'تم الرد على تقييم العميل بنجاح',
            'data' => $review
        ]);
    }

    /**
     * API لبطاقة: رسائل العملاء الخاصة بالمتجر
     */
    public function getMessages(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        $messages = \App\Models\StoreMessage::where('store_id', $storeId)
            ->where('is_from_vendor', false)
            ->with('user') // if relations exist
            ->latest()
            ->paginate(15);

        return response()->json([
            'label' => 'رسائل العملاء الواردة',
            'data' => $messages
        ]);
    }

    /**
     * API لبطاقة: تقرير أداء الردود التلقائية (الشات بوت)
     */
    public function getChatbotReport(): JsonResponse
    {
        $storeId = auth()->user()->store->id;
        
        $totalBotReplies = \App\Models\StoreMessage::where('store_id', $storeId)
            ->where('is_from_vendor', true)
            ->where('customer_name', 'الرد التلقائي')
            ->count();

        $totalManualReplies = \App\Models\StoreMessage::where('store_id', $storeId)
            ->where('is_from_vendor', true)
            ->where('customer_name', '!=', 'الرد التلقائي')
            ->count();

        $popularTriggers = \DB::table('store_messages')
            ->where('store_id', $storeId)
            ->where('customer_name', 'الرد التلقائي')
            ->select('message', \DB::raw('count(*) as count'))
            ->groupBy('message')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        return response()->json([
            'label' => 'تقرير أداء الرد الآلي',
            'data' => [
                'bot_replies_count' => $totalBotReplies,
                'manual_replies_count' => $totalManualReplies,
                'top_automatic_responses' => $popularTriggers,
                'completion_rate' => $totalBotReplies + $totalManualReplies > 0 
                    ? round(($totalBotReplies / ($totalBotReplies + $totalManualReplies)) * 100, 2) . '%'
                    : '0%'
            ]
        ]);
    }
}
