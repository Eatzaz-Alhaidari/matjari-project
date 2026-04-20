<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('floosak_refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('floosak_payment_attempt_id')
                ->constrained('floosak_payment_attempts')
                ->cascadeOnDelete();
            $table->string('request_id')->unique();
            $table->decimal('amount', 15, 2);
            $table->string('gateway_refund_transaction_id')->nullable()->index();
            $table->string('gateway_reference_id')->nullable()->index();
            $table->string('gateway_status_en')->nullable();
            $table->string('gateway_status_ar')->nullable();
            $table->string('status')->index();
            $table->json('refund_request_payload')->nullable();
            $table->json('refund_response_payload')->nullable();
            $table->json('last_error_payload')->nullable();
            $table->text('last_error_message')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('floosak_refunds');
    }
};
