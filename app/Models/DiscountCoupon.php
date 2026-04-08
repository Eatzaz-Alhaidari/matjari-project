<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCoupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'expiry_date',
        'is_active'
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
    ];
}
