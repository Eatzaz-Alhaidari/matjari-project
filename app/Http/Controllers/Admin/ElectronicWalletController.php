<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ElectronicWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ElectronicWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = ElectronicWallet::latest()->get();
        return view('admin.electronic-wallets.index', compact('wallets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.electronic-wallets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'wallet_name' => 'required|string|max:255',
            'wallet_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'provider' => 'required|string|max:255',
            'merchant_number' => 'required|string|max:255',
            'payment_mode' => 'required|in:manual,api',
            'verification_method' => 'required|in:manual,automatic',
            'address' => 'required|string|max:255',
            'payment_instructions' => 'nullable|string',
            'balance' => 'nullable|numeric',
        ]);

        $data = $request->except('wallet_logo');

        if ($request->hasFile('wallet_logo')) {
            $path = $request->file('wallet_logo')->store('wallets', 'public');
            $data['wallet_logo'] = $path;
        }

        $data['is_active'] = $request->has('is_active');

        ElectronicWallet::create($data);

        return redirect()->route('admin.electronic-wallets.index')
            ->with('success', 'تم إضافة المحفظة بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ElectronicWallet $electronic_wallet)
    {
        return view('admin.electronic-wallets.edit', compact('electronic_wallet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ElectronicWallet $electronic_wallet)
    {
        $request->validate([
            'wallet_name' => 'required|string|max:255',
            'wallet_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'provider' => 'required|string|max:255',
            'merchant_number' => 'required|string|max:255',
            'payment_mode' => 'required|in:manual,api',
            'verification_method' => 'required|in:manual,automatic',
            'address' => 'required|string|max:255',
            'payment_instructions' => 'nullable|string',
            'balance' => 'nullable|numeric',
        ]);

        $data = $request->except('wallet_logo');

        if ($request->hasFile('wallet_logo')) {
            // Delete old image if exists
            if ($electronic_wallet->wallet_logo) {
                Storage::disk('public')->delete($electronic_wallet->wallet_logo);
            }
            $path = $request->file('wallet_logo')->store('wallets', 'public');
            $data['wallet_logo'] = $path;
        }

        $data['is_active'] = $request->has('is_active');

        $electronic_wallet->update($data);

        return redirect()->route('admin.electronic-wallets.index')
            ->with('success', 'تم تحديث المحفظة بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ElectronicWallet $electronic_wallet)
    {
        if ($electronic_wallet->wallet_logo) {
            Storage::disk('public')->delete($electronic_wallet->wallet_logo);
        }
        $electronic_wallet->delete();

        return redirect()->route('admin.electronic-wallets.index')
            ->with('success', 'تم حذف المحفظة بنجاح.');
    }
}
