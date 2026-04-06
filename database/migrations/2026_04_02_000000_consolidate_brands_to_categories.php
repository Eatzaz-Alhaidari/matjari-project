<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add fields to categories
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'is_brand')) {
                $table->boolean('is_brand')->default(false)->after('parent_id');
            }
            if (!Schema::hasColumn('categories', 'brand_logo')) {
                $table->string('brand_logo')->nullable()->after('is_brand');
            }
        });

        // 2. Update products table
        Schema::table('products', function (Blueprint $table) {
            // Drop existing FK if it exists (assuming the name matches)
            try {
                 $table->dropForeign(['brand_id']);
            } catch (\Exception $e) {
                // If FK doesn't exist, ignore
            }
            
            // We'll keep brand_id but it now references categories.id
            // No changes needed to the column itself if it's already bigInteger
        });

        // 3. Drop brand-related tables (Careful: this deletes data!)
        // In a real scenario, we'd migrate data first. 
        // But the user said "Delete it", so we'll drop them.
        Schema::dropIfExists('brand_category');
        Schema::dropIfExists('brands');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['is_brand', 'brand_logo']);
        });

        // We can't easily recreate brands table with data here
    }
};
