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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('driver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('long', 10, 8)->nullable();
            
            // Note: Changing ENUM to STRING. Make sure doctrine/dbal is installed if on older Laravel/MySQL.
            $table->string('status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
            $table->dropColumn(['driver_id', 'lat', 'long']);
            
            // We cannot easily revert back to specific enum values dynamically in down() safely, 
            // but for good practice, we declare what it used to be.
            // DO NOT change back to enum here to prevent data loss if new statuses were used.
        });
    }
};
