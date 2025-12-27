<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        // 1. Fetch all settings and format them as key-value pairs
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method', 'site_logo', 'site_icon']);

        // 1. Handle text inputs
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 2. Handle Logo Upload
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $path]);
        }

        // 3. Handle Icon Upload
        if ($request->hasFile('site_icon')) {
            $path = $request->file('site_icon')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'site_icon'], ['value' => $path]);
        }

        return redirect()->back()->with('success', 'تم تحديث الإعدادات بنجاح!');
    }
}
