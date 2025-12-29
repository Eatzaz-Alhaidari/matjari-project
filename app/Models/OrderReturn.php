<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\User;

class OrderReturn extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'user_id',
        'reason',
        'status',
        'is_restocked',
        'refund_amount',
        'admin_response',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
