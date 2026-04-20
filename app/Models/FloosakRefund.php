<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FloosakRefund extends Model
{
    public const STATUS_INITIATING = 'initiating';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_UNKNOWN = 'unknown';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'floosak_payment_attempt_id',
        'request_id',
        'amount',
        'gateway_refund_transaction_id',
        'gateway_reference_id',
        'gateway_status_en',
        'gateway_status_ar',
        'status',
        'refund_request_payload',
        'refund_response_payload',
        'last_error_payload',
        'last_error_message',
        'completed_at',
        'failed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'refund_request_payload' => 'array',
        'refund_response_payload' => 'array',
        'last_error_payload' => 'array',
        'completed_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    public function paymentAttempt(): BelongsTo
    {
        return $this->belongsTo(FloosakPaymentAttempt::class, 'floosak_payment_attempt_id');
    }
}
