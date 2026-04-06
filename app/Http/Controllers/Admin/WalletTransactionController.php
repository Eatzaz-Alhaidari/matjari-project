<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class WalletTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = WalletTransaction::with('user');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('reference_number', 'like', "%{$q}%")
                    ->orWhere('network_transfer_number', 'like', "%{$q}%")
                    ->orWhere('sender_name', 'like', "%{$q}%")
                    ->orWhere('beneficiary_name', 'like', "%{$q}%")
                    ->orWhere('sender_phone', 'like', "%{$q}%")
                    ->orWhere('beneficiary_phone', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->orderByDesc('created_at')->paginate(20);

        $totalAmount    = WalletTransaction::sum('amount');
        $totalFees      = WalletTransaction::sum('fee');
        $countToday     = WalletTransaction::whereDate('created_at', today())->count();

        return view('admin.wallet-transactions.index', compact(
            'transactions', 'totalAmount', 'totalFees', 'countToday'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reference_number'        => 'nullable|string|max:100',
            'operation'               => 'nullable|string|max:200',
            'transaction_date'        => 'nullable|date',
            'network_transfer_number' => 'nullable|string|max:100',
            'amount'                  => 'required|numeric|min:0',
            'fee'                     => 'nullable|numeric|min:0',
            'total'                   => 'nullable|numeric|min:0',
            'sender_name'             => 'nullable|string|max:255',
            'sender_phone'            => 'nullable|string|max:30',
            'beneficiary_name'        => 'nullable|string|max:255',
            'beneficiary_phone'       => 'nullable|string|max:30',
            'notes'                   => 'nullable|string',
            'status'                  => 'nullable|string|max:50',
        ]);

        $data['fee']   = $data['fee']   ?? 0;
        $data['total'] = $data['total'] ?? ($data['amount'] + $data['fee']);

        WalletTransaction::create($data);

        return redirect()->route('admin.wallet-transactions.index')
            ->with('success', 'تم إضافة العملية بنجاح.');
    }

    public function destroy(WalletTransaction $walletTransaction)
    {
        $walletTransaction->delete();
        return redirect()->route('admin.wallet-transactions.index')
            ->with('success', 'تم حذف العملية بنجاح.');
    }
}
