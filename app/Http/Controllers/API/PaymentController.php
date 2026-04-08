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
                'icon' => asset('assets/icons/cod.png') 
            ];
        }

        // Jeeb (Wallet)
        if (($settings['payment_jeeb_enabled'] ?? '0') == '1') {
            $methods[] = [
                'id' => 'wallet',
                'name' => 'محفظة جـيب',
                'description' => 'ادفع من رصيدك في المحفظة',
                'icon' => asset('assets/icons/wallet.png')
            ];
        }

        // Bank Transfer
        if (($settings['payment_transfer_enabled'] ?? '0') == '1') {
            $methods[] = [
                'id' => 'bank_transfer',
                'name' => 'تحويل بنكي',
                'description' => 'تحويل المبلغ إلى حسابنا البنكي',
                'icon' => asset('assets/icons/bank.png'),
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

    /**
     * Get list of Electronic Wallets for manual charging from Mobile App
     */
    public function getWallets()
    {
        $wallets = \App\Models\ElectronicWallet::where('is_active', true)
            ->get(['id', 'wallet_name', 'wallet_logo', 'provider', 'merchant_number', 'address']);

        return response()->json([
            'status' => true,
            'data' => $wallets->map(function($w) {
                $w->wallet_logo = $w->wallet_logo ? asset('storage/'.$w->wallet_logo) : null;
                return $w;
            })
        ]);
    }
}
