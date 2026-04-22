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
            $table->enum('ai_status', ['pending', 'approved', 'rejected', 'needs_edit', 'failed_service'])->default('pending')->after('status');
            $table->json('ai_notes')->nullable()->after('ai_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['ai_status', 'ai_notes']);
        });
    }
};
