<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectronicWallet extends Model
{
    protected $fillable = [
        'wallet_name',
        'wallet_logo',
        'provider',
        'merchant_number',
        'balance',
        'payment_mode',
        'api_key',
        'verify_api_url',
        'verification_method',
        'address',
        'payment_instructions',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'balance' => 'decimal:2',
    ];
}
