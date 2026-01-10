<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'type', // deposit, withdrawal, purchase, refund, transfer
        'amount',
        'reference_id',
        'description',
        'status', // pending, completed, failed, cancelled
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
