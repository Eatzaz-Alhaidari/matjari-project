<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'vendor_id',
        'title',
        'image',
        'description',
        'status',
        'rejection_reason',
        'start_date',
        'end_date',
        'budget',
        'clicks',
        'views',
        'target_url',
        'is_admin',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'float',
        'status' => 'integer',
        'is_admin' => 'boolean',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            0 => 'في الانتظار',
            1 => 'نشط',
            2 => 'مرفوض',
            3 => 'معطل مؤقتاً',
            default => 'غير معروف',
        };
    }

    public function isActive()
    {
        return $this->status === 1;
    }
}
