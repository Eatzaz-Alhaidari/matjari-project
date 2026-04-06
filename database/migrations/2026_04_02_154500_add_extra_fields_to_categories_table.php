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
        Schema::table('categories', function (Blueprint $row) {
            $row->string('banner')->nullable()->after('brand_logo');
            $row->string('icon')->nullable()->after('banner');
            $row->boolean('is_popular')->default(false)->after('icon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $row) {
            $row->dropColumn(['banner', 'icon', 'is_popular']);
        });
    }
};
