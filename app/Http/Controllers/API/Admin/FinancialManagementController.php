<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FinancialManagementController extends Controller
{
    /**
     * API لبطاقة: التقارير المالية (نظرة شاملة على المحافظ)
     */
    public function getGlobalWallets(Request $request): JsonResponse
    {
        $query = Wallet::with('user');

        $wallets = $query->paginate(20);

        return response()->json([
            'label' => 'إدارة التقارير المالية والمحافظ',
            'data' => $wallets
        ]);
    }

    /**
     * API لبطاقة: حركات المحفظة
     */
    public function getGlobalTransactions(Request $request): JsonResponse
    {
        $type = $request->get('type');
        $query = WalletTransaction::with('wallet.user');

        if ($type) {
            $query->where('type', $type);
        }

        $transactions = $query->latest()->paginate(30);

        return response()->json([
            'label' => 'سجل حركات المحافظ المالية',
            'data' => $transactions
        ]);
    }

    /**
     * عرض تفاصيل معاملة مالية معينة للأدمن
     */
    public function showTransaction($id): JsonResponse
    {
        $transaction = WalletTransaction::with('wallet.user')->findOrFail($id);

        return response()->json([
            'label' => 'تفاصيل الحركات المالية',
            'data' => $transaction
        ]);
    }
}
