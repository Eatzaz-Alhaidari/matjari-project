<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FloosakPaymentAttempt extends Model
{
    public const STATUS_INITIATING = 'initiating';
    public const STATUS_PENDING = 'pending';
    public const STATUS_SEND_UNKNOWN = 'send_unknown';
    public const STATUS_SEND_FAILED = 'send_failed';
    public const STATUS_CONFIRMING = 'confirming';
    public const STATUS_CONFIRM_UNKNOWN = 'confirm_unknown';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    public const ACTIVE_STATUSES = [
        self::STATUS_INITIATING,
        self::STATUS_PENDING,
        self::STATUS_SEND_UNKNOWN,
        self::STATUS_CONFIRMING,
        self::STATUS_CONFIRM_UNKNOWN,
    ];

    protected $fillable = [
        'order_id',
        'user_id',
        'request_id',
        'source_wallet_id',
        'target_phone',
        'amount',
        'purpose',
        'gateway_purchase_id',
        'gateway_transaction_id',
        'gateway_reference_id',
        'gateway_status_en',
        'gateway_status_ar',
        'net',
        'fee',
        'gross',
        'balance',
        'status',
        'send_request_payload',
        'send_response_payload',
        'confirm_response_payload',
        'status_response_payload',
        'last_error_code',
        'last_error_message',
        'last_error_payload',
        'reconciliation_attempts',
        'last_reconciled_at',
        'next_reconcile_at',
        'completed_at',
        'failed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'net' => 'decimal:2',
        'fee' => 'decimal:2',
        'gross' => 'decimal:2',
        'balance' => 'decimal:2',
        'send_request_payload' => 'array',
        'send_response_payload' => 'array',
        'confirm_response_payload' => 'array',
        'status_response_payload' => 'array',
        'last_error_payload' => 'array',
        'last_reconciled_at' => 'datetime',
        'next_reconcile_at' => 'datetime',
        'completed_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(FloosakRefund::class);
    }

    public function isActive(): bool
    {
        return in_array($this->status, self::ACTIVE_STATUSES, true);
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}
