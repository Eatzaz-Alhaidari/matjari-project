<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    public function index()
    {
        $totalBalances = Wallet::sum('balance');
        $totalEarnings = Wallet::sum('total_earnings');
        $totalWithdrawals = Wallet::sum('withdrawn_amount');

        return view('admin.reports.financial', compact('totalBalances', 'totalEarnings', 'totalWithdrawals'));
    }
}
