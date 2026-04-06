<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference_number',
        'operation',
        'transaction_date',
        'network_transfer_number',
        'amount',
        'fee',
        'total',
        'sender_name',
        'sender_phone',
        'beneficiary_name',
        'beneficiary_phone',
        'notes',
        'status',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'amount'           => 'decimal:2',
        'fee'              => 'decimal:2',
        'total'            => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

