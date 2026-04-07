<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\ChatbotRule;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    /**
     * View chatbot rules page
     */
    public function index()
    {
        $storeId = auth()->user()->store->id;
        $chatbotRules = ChatbotRule::where('store_id', $storeId)->latest()->get();
        return view('vendor.chatbot.index', compact('chatbotRules'));
    }
    /**
     * حفظ قاعدة شات بوت جديدة
     */
    public function store(Request $request)
    {
        $request->validate([
            'trigger_keyword' => 'required|string|max:255',
            'response_text' => 'required|string',
        ]);

        $store = auth()->user()->store;

        ChatbotRule::create([
            'store_id' => $store->id,
            'trigger_keyword' => $request->trigger_keyword,
            'response_text' => $request->response_text,
        ]);

        return back()->with('success', 'تم إضافة قاعدة الرد التلقائي بنجاح');
    }

    /**
     * حذف قاعدة شات بوت
     */
    public function destroy(ChatbotRule $chatbot)
    {
        // التحقق من أن القاعدة تابعة لمتجر المستخدم الحالي
        if ($chatbot->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        $chatbot->delete();

        return back()->with('success', 'تم حذف قاعدة الرد التلقائي');
    }
}
