<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Advertisement extends Model
{
    protected $fillable = [
        'store_id',
        'title',
        'description',
        'image',
        'status',
        'start_date',
        'end_date',
        'budget',
        'clicks',
        'views',
        'target_url',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'clicks' => 'integer',
        'views' => 'integer',
    ];

    // العلاقات
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    // Helper methods
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'active' => 'green',
            'inactive' => 'red',
            'pending' => 'yellow',
            default => 'gray',
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'active' => 'نشط',
            'inactive' => 'معطل',
            'pending' => 'في الانتظار',
            default => 'غير محدد',
        };
    }

    public function isActive()
    {
        return $this->status === 'active' &&
               $this->start_date <= now() &&
               $this->end_date >= now();
    }

    public function getDaysRemainingAttribute()
    {
        return now()->diffInDays($this->end_date, false);
    }

    public function getClickThroughRateAttribute()
    {
        return $this->views > 0 ? ($this->clicks / $this->views) * 100 : 0;
    }
}
