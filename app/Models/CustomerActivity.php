<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerActivity extends Model
{
    protected $fillable = [
        'user_id',
        'activity_type',
        'description',
        'ip_address',
        'device_info'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
