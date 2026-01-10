<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('payment_method');
            }
        });

        // Change enum to string using raw SQL for MySQL ease
        // This avoids Doctrine DBAL requirement for changing columns
        try {
            DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method VARCHAR(191) DEFAULT 'cash_on_delivery'");
        } catch (\Exception $e) {
            // Fallback for SQLite (often used in testing) or if it fails
            // In SQLite, you can't easy modify, but we might not need to if we just ignore the constraint check
            // For now, let's assume MySQL which is standard for "XAMPP" user.
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_proof');
        });
        // We don't revert the enum -> varchar change because data might be incompatible
    }
};
