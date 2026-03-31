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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('warranty');
            $table->integer('warranty_duration')->nullable()->after('category_id');
            $table->enum('warranty_unit', ['days', 'months', 'years'])->nullable()->after('warranty_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['warranty_duration', 'warranty_unit']);
            $table->string('warranty')->nullable()->after('category_id');
        });
    }
};
