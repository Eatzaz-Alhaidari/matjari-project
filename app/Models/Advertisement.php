<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Advertisement extends Model
{
    protected $fillable = [
        'store_id',
        'vendor_id', // New
        'is_admin', // New
        'title',
        'description',
        'image',
        'status', // Now Integer: 0 or 1
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
        'is_admin' => 'boolean',
        'status' => 'integer',
    ];

    // العلاقات
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 1)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    // Helper methods
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            1 => 'green',
            0 => 'yellow',
            default => 'gray',
        };
    }

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            1 => 'نشط',
            0 => 'في الانتظار',
            default => 'غير محدد',
        };
    }

    public function isActive()
    {
        return $this->status === 1 &&
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
