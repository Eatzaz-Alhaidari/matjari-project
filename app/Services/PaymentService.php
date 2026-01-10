<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Exception;

class PaymentService
{
    /**
     * Process payment from Wallet
     */
    public function payWithWallet(User $user, float $amount, Order $order)
    {
        return DB::transaction(function () use ($user, $amount, $order) {
            $wallet = $user->wallet()->lockForUpdate()->firstOrCreate([]); // Lock wallet row

            if ($wallet->balance < $amount) {
                throw new Exception("رصيد المحفظة غير كافي.");
            }

            // Deduct balance
            $wallet->balance -= $amount;
            $wallet->save();

            // Record Transaction
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'purchase',
                'amount' => $amount,
                'reference_id' => $order->id, // Order ID
                'description' => "شراء الطلب رقم #{$order->order_number}",
                'status' => 'completed'
            ]);

            // Update Order
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing' // Or leave as pending/processing depending on workflow
            ]);

            return true;
        });
    }

    /**
     * Handle Manual Transfer confirmation
     */
    public function confirmTransfer(Order $order)
    {
        // Here we just mark the order as paid.
        // If we want to credit the VENDOR wallet immediately, we can do it here,
        // but typically for multi-vendor, we hold funds in Admin account then distribute.
        // For this task, we just confirm the USER paid the PLATFORM.

        $order->update(['payment_status' => 'paid']);
        return true;
    }
}
