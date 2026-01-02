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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('shipping_company')->default('توصيل');
            $table->string('shipment_id')->nullable(); // External ID from shipping company
            $table->string('tracking_number')->unique();
            $table->enum('status', ['pending', 'picked_up', 'in_transit', 'delivered', 'failed'])->default('pending');
            $table->decimal('cost', 10, 2)->default(1000.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
