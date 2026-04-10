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
        Schema::table('addresses', function (Blueprint $table) {
            $table->text('details')->nullable()->after('address');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()->after('product_id')->constrained()->onDelete('cascade');
        });

        Schema::table('store_messages', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('store_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('details');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
        });

        Schema::table('store_messages', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
