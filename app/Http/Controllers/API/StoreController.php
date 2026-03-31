<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreMessage;
use App\Models\ChatbotRule;
use App\Http\Requests\StoreRequest;
use App\Http\Resources\StoreResource;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * إرسال رسالة للمتجر (من العميل) + تفعيل الشات بوت
     */
    public function submitMessage(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'customer_name' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // 1. حفظ رسالة العميل
        $customerMessage = StoreMessage::create([
            'store_id' => $request->store_id,
            'customer_name' => $request->customer_name ?? 'عميل',
            'message' => $request->message,
            'is_from_vendor' => false,
        ]);

        // 2. تفعيل منطق الشات بوت (Chatbot Logic)
        $reply = null;
        $rules = ChatbotRule::where('store_id', $request->store_id)->get();
        
        foreach ($rules as $rule) {
            // البحث عن الكلمة المفتاحية في نص الرسالة (تجاهل حالة الأحرف)
            if (mb_stripos($request->message, $rule->trigger_keyword) !== false) {
                $reply = StoreMessage::create([
                    'store_id' => $request->store_id,
                    'customer_name' => 'الرد التلقائي',
                    'message' => $rule->response_text,
                    'is_from_vendor' => true,
                    'is_read' => true,
                ]);
                break; // نكتفي بأول رد مطابق
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'customer_message' => $customerMessage,
            'chatbot_reply' => $reply
        ]);
    }

    /**
     * جلب رسائل التاجر (آخر 5 رسائل)
     */
    public function getVendorMessages(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->store) {
            return response()->json([
                'success' => false,
                'message' => 'User does not have a store'
            ], 404);
        }

        $messages = StoreMessage::where('store_id', $user->store->id)
            ->latest()
            ->limit(5)
            ->get();

        $formattedMessages = $messages->map(function ($msg) {
            return [
                'id' => $msg->id,
                'customer_name' => $msg->customer_name ?? 'عميل',
                'message' => $msg->message,
                'created_at' => $msg->created_at->toDateTimeString(),
                'time_ago' => $msg->created_at->diffForHumans(),
                'is_read' => (bool) $msg->is_read
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedMessages
        ]);
    }
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
