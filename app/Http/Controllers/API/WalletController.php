<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Get Wallet Balance & Transactions
     */
    public function show(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        $wallet = $user->wallet()->firstOrCreate([]);

        $transactions = $wallet->transactions()->latest()->paginate(10);

        return response()->json([
            'status' => true,
            'data' => [
                'balance' => (float) $wallet->balance,
                'currency' => 'RWF', // or preferred currency
                'transactions' => $transactions
            ]
        ]);
    }

    /**
     * Submit a new wallet transaction (proof of transfer)
     */
    public function storeTransaction(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'electronic_wallet_id'    => 'required|exists:electronic_wallets,id',
            'amount'                  => 'required|numeric|min:1',
            'reference_number'        => 'nullable|string|max:100',
            'network_transfer_number' => 'nullable|string|max:100',
            'sender_name'             => 'required|string|max:255',
            'sender_phone'            => 'required|string|max:30',
            'notes'                   => 'nullable|string',
        ]);

        $transaction = \App\Models\WalletTransaction::create([
            'user_id'                 => $user->id,
            'electronic_wallet_id'    => $validated['electronic_wallet_id'],
            'amount'                  => $validated['amount'],
            'reference_number'        => $validated['reference_number'] ?? null,
            'network_transfer_number' => $validated['network_transfer_number'] ?? null,
            'sender_name'             => $validated['sender_name'],
            'sender_phone'            => $validated['sender_phone'],
            'notes'                   => $validated['notes'] ?? null,
            'status'                  => 'pending', // Pending Admin Approval
            'operation'               => 'شحن رصيد / إيداع من التطبيق',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم إرسال طلب الشحن بنجاح وهو قيد المراجعة',
            'data' => $transaction
        ], 201);
    }
}
