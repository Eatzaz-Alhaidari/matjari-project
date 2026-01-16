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
        Schema::create('electronic_wallets', function (Blueprint $table) {
            $table->id();
            $table->string('wallet_name'); // اسم المحفظة
            $table->string('wallet_logo')->nullable(); // شعار المحفظة
            $table->string('provider'); // الشركة التابعة
            $table->string('merchant_number'); // رقم التاجر
            $table->decimal('balance', 15, 2)->default(0); // رصيد المحفظة
            $table->enum('payment_mode', ['manual', 'api'])->default('manual'); // manual / api
            $table->string('api_key')->nullable(); // (اختياري)
            $table->string('verify_api_url')->nullable(); // (اختياري)
            $table->enum('verification_method', ['manual', 'automatic'])->default('manual'); // manual / automatic
            $table->string('address'); // عنوان التحويل
            $table->text('payment_instructions')->nullable(); // تفاصيل الدفع
            $table->boolean('is_active')->default(true); // حالة التفعيل
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electronic_wallets');
    }
};
