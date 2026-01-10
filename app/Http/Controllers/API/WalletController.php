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
}
