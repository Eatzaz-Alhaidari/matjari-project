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
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_code')->nullable()->index()->after('id');
            $table->decimal('cost_price', 10, 2)->nullable()->after('price');
            $table->decimal('price_before', 10, 2)->nullable()->after('cost_price');
            $table->unsignedInteger('min_stock')->default(0)->after('stock');
            $table->text('notes')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['product_code', 'cost_price', 'price_before', 'min_stock', 'notes']);
        });
    }
};
