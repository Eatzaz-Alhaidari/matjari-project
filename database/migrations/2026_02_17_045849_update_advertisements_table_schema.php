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
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('advertisements', function (Blueprint $table) {
            $table->integer('status')->default(0); // 0: Pending, 1: Active
            $table->foreignId('vendor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->boolean('is_admin')->default(false);
            $table->foreignId('store_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropColumn(['vendor_id', 'is_admin']);
            $table->dropColumn('status');
        });

        Schema::table('advertisements', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
        });
    }
};
