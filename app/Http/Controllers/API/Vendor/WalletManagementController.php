<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WalletManagementController extends Controller
{
    /**
     * API لبطاقة: رصيد المحفظة والأرباح للبائع
     */
    public function getWallet(): JsonResponse
    {
        $userId = auth()->id();
        $wallet = Wallet::where('user_id', $userId)->first();

        return response()->json([
            'label' => 'رصيد المحفظة والأرباح',
            'data' => $wallet
        ]);
    }

    /**
     * API لبطاقة: سجل الحركات المالية (للبائع)
     */
    public function getTransactions(Request $request): JsonResponse
    {
        $userId = auth()->id();
        $wallet = Wallet::where('user_id', $userId)->first();
        
        if (!$wallet) {
            return response()->json(['message' => 'لا توجد محفظة مرتبطة'], 404);
        }

        $query = WalletTransaction::where('wallet_id', $wallet->id);

        $transactions = $query->latest()->paginate(15);

        return response()->json([
            'label' => 'سجل حركات المحفظة الخاصة',
            'data' => $transactions
        ]);
    }
}
