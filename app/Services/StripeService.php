<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Exception;

class StripeService
{
    public function __construct()
    {
        $apiKey = Setting::where('key', 'stripe_secret_key')->value('value');
        if ($apiKey) {
            Stripe::setApiKey($apiKey);
        }
    }

    /**
     * Charge a credit card
     * 
     * @param float $amount
     * @param string $token Source token from Stripe.js
     * @param string $currency
     * @return object Stripe Charge Object
     * @throws Exception
     */
    public function charge(float $amount, string $token, string $currency = 'USD')
    {
        try {
            // Stripe accepts amount in cents
            $amountInCents = round($amount * 100);

            $charge = Charge::create([
                'amount' => $amountInCents,
                'currency' => strtolower($currency),
                'source' => $token,
                'description' => 'Order Payment from Matjari Platform',
            ]);

            return $charge;
        } catch (\Exception $e) {
            Log::error('Stripe Payment Error: ' . $e->getMessage());
            throw new Exception('فشل عملية الدفع: ' . $e->getMessage());
        }
    }
}
