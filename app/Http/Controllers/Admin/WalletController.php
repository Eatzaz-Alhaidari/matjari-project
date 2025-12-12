<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::with('vendor')->latest()->paginate(10);
        return view('admin.wallets.index', compact('wallets'));
    }
}
