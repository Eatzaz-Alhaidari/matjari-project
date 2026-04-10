<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreMessage extends Model
{
    protected $fillable = [
        'store_id',
        'user_id',
        'customer_name',
        'message',
        'is_read',
        'is_from_vendor',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
