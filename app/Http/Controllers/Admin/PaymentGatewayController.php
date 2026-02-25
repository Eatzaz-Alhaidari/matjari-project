<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        // Define keys we want to manage
        $keys = [
            'payment_cod_enabled',
            'payment_jeeb_enabled',
            'payment_transfer_enabled',
            'payment_credit_card_enabled',
            'stripe_publishable_key',
            'stripe_secret_key',
            'bank_name',
            'bank_account_name',
            'bank_account_number',
            'bank_iban'
        ];

        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key')->toArray();

        return view('admin.payment-gateways.index', compact('settings'));
    }

    public function store(Request $request)
    {
        // Handle Checkboxes (if unchecked they don't appear in request)
        $inputs = $request->except('_token');

        // Explicitly handle checkboxes to save '0' if unchecked
        $checkboxes = ['payment_cod_enabled', 'payment_jeeb_enabled', 'payment_transfer_enabled', 'payment_credit_card_enabled'];
        foreach ($checkboxes as $chk) {
            $inputs[$chk] = $request->has($chk) ? '1' : '0';
        }

        foreach ($inputs as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'تم تحديث إعدادات طرق الدفع بنجاح.');
    }
}
