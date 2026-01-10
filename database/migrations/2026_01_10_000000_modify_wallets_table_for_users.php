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
        // Check if user_id exists from a failed previous run
        if (!Schema::hasColumn('wallets', 'user_id')) {
            Schema::table('wallets', function (Blueprint $table) {
                // Drop FK first (standard naming convention attempt)
                // We use array syntax to let Laravel guess the index name or provide the explicit name if known
                //$table->dropForeign(['vendor_id']); 
                // Or explicit name typically 'wallets_vendor_id_foreign'
                $table->dropForeign('wallets_vendor_id_foreign');

                // Now rename
                $table->renameColumn('vendor_id', 'user_id');

                // Add new FK
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id', 'vendor_id');
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
