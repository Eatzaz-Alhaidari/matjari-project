<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('reference_number')->nullable()->comment('رقم مرجع العملية');
            $table->string('operation')->nullable()->comment('العملية مثل إرسال حوالة');
            $table->timestamp('transaction_date')->nullable();
            $table->string('network_transfer_number')->nullable()->comment('رقم حوالة شبكة تحويل');
            $table->decimal('amount', 12, 2)->default(0)->comment('المبلغ الصافي');
            $table->decimal('fee', 10, 2)->default(0)->comment('العمولة');
            $table->decimal('total', 12, 2)->default(0)->comment('الإجمالي');
            $table->string('sender_name')->nullable();
            $table->string('sender_phone')->nullable();
            $table->string('beneficiary_name')->nullable();
            $table->string('beneficiary_phone')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('completed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
