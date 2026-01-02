<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $timestamps = false; // We only need created_at which is handled by DB or manually

    protected $fillable = [
        'user_id',
        'user_type',
        'action_type',
        'subject_type',
        'subject_id',
        'description',
        'ip_address',
        'user_agent',
        'severity',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
