<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discount extends Model
{
    protected $fillable = [
        'store_id',
        'title',
        'description',
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_discount_amount',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'status',
        'applicable_products',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'applicable_products' => 'array',
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
            'expired' => 'gray',
            default => 'gray',
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'active' => 'نشط',
            'inactive' => 'معطل',
            'expired' => 'منتهي الصلاحية',
            default => 'غير محدد',
        };
    }

    public function getTypeTextAttribute()
    {
        return match($this->type) {
            'percentage' => 'نسبة مئوية',
            'fixed' => 'مبلغ ثابت',
            default => 'غير محدد',
        };
    }

    public function isActive()
    {
        return $this->status === 'active' &&
               $this->start_date <= now() &&
               $this->end_date >= now() &&
               ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }

    public function isExpired()
    {
        return $this->end_date < now() ||
               ($this->usage_limit !== null && $this->used_count >= $this->usage_limit);
    }

    public function getDaysRemainingAttribute()
    {
        return now()->diffInDays($this->end_date, false);
    }

    public function getUsagePercentageAttribute()
    {
        if ($this->usage_limit === null) {
            return 0;
        }
        return ($this->used_count / $this->usage_limit) * 100;
    }

    public function calculateDiscount($orderAmount)
    {
        if (!$this->isActive() || $orderAmount < $this->min_order_amount) {
            return 0;
        }

        $discount = 0;

        if ($this->type === 'percentage') {
            $discount = ($orderAmount * $this->value) / 100;
        } else {
            $discount = $this->value;
        }

        // تطبيق الحد الأقصى للخصم إذا كان محدد
        if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
            $discount = $this->max_discount_amount;
        }

        return $discount;
    }

    public function canApplyToProducts($productIds)
    {
        if (empty($this->applicable_products)) {
            return true; // ينطبق على جميع المنتجات
        }

        return !empty(array_intersect($productIds, $this->applicable_products));
    }
}
