<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        \DB::table('settings')->insert([
            ['key' => 'site_name', 'value' => 'متجري'],
            ['key' => 'site_description', 'value' => 'منصة متعددة البائعين'],
            ['key' => 'commission_rate', 'value' => '10'], // 10%
            ['key' => 'auto_approve_vendors', 'value' => '0'],
            ['key' => 'auto_approve_products', 'value' => '0'],
            ['key' => 'support_email', 'value' => 'support@matjari.com'],
            ['key' => 'support_phone', 'value' => ''],
            ['key' => 'maintenance_mode', 'value' => '0'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
