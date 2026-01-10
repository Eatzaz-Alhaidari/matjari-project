<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Get Available Payment Methods
     */
    public function getPaymentMethods()
    {
        $settings = Setting::whereIn('key', [
            'payment_cod_enabled',
            'payment_jeeb_enabled',
            'payment_transfer_enabled',
            'bank_name',
            'bank_account_name',
            'bank_account_number',
            'bank_iban'
        ])->pluck('value', 'key');

        $methods = [];

        // COD
        if (($settings['payment_cod_enabled'] ?? '0') == '1') {
            $methods[] = [
                'id' => 'cash_on_delivery',
                'name' => 'الدفع عند الاستلام',
                'description' => 'ادفع نقداً عند استلام طلبك',
                'icon' => 'cod_icon_url_here' // Replace with asset url if needed
            ];
        }

        // Jeeb (Wallet)
        if (($settings['payment_jeeb_enabled'] ?? '0') == '1') {
            $methods[] = [
                'id' => 'wallet',
                'name' => 'محفظة جـيب',
                'description' => 'ادفع من رصيدك في المحفظة',
                'icon' => 'wallet_icon_url_here'
            ];
        }

        // Bank Transfer
        if (($settings['payment_transfer_enabled'] ?? '0') == '1') {
            $methods[] = [
                'id' => 'bank_transfer',
                'name' => 'تحويل بنكي',
                'description' => 'تحويل المبلغ إلى حسابنا البنكي',
                'icon' => 'bank_icon_url_here',
                'bank_details' => [
                    'bank_name' => $settings['bank_name'] ?? '',
                    'account_name' => $settings['bank_account_name'] ?? '',
                    'account_number' => $settings['bank_account_number'] ?? '',
                    'iban' => $settings['bank_iban'] ?? '',
                ]
            ];
        }

        return response()->json([
            'status' => true,
            'data' => $methods
        ]);
    }
}
