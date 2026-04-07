<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\StoreMessage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Display a listing of customer messages.
     */
    public function index(): View
    {
        $storeId = auth()->user()->store->id;
        
        $messages = StoreMessage::where('store_id', $storeId)
            ->latest()
            ->paginate(15);
            
        // Optional: mark newly viewed messages as read
        // StoreMessage::where('store_id', $storeId)->where('is_read', false)->update(['is_read' => true]);

        return view('vendor.messages.index', compact('messages'));
    }
}
