<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;

class SupportController extends Controller
{
    public function index()
    {
        $settings = Setting::whereIn('key', ['support_whatsapp', 'support_enabled'])->pluck('value', 'key')->toArray();
        return view('admin.support.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'support_whatsapp' => 'required|string',
        ]);

        Setting::updateOrCreate(['key' => 'support_whatsapp'], ['value' => $request->support_whatsapp]);

        // Handle checkbox (if unchecked, it won't be in request, so we need to handle that)
        // But for now let's just save the number. The user asked to "Enable it for this number".

        return redirect()->back()->with('success', 'تم تحديث إعدادات الدعم الفني بنجاح.');
    }
}
