<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('wallet_transactions')) {
            Schema::create('wallet_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
                $table->enum('type', ['deposit', 'withdrawal', 'purchase', 'refund', 'transfer']);
                $table->decimal('amount', 10, 2);
                $table->string('reference_id')->nullable(); // e.g. Order ID or Transaction ID
                $table->string('description')->nullable();
                $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('completed');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
