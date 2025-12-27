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
        Schema::table('stores', function (Blueprint $table) {
            // معلومات إضافية للمتجر (شعار نصي، صورة غلاف)
            $table->string('slogan')->nullable()->after('name');
            $table->string('cover_image_path')->nullable()->after('logo_path');

            // معلومات التواصل والدعم
            $table->string('support_phone')->nullable()->after('address');
            $table->string('support_email')->nullable()->after('support_phone');

            // السياسات
            $table->text('shipping_policy')->nullable()->after('description');
            $table->text('return_policy')->nullable()->after('shipping_policy');

            // النظام المحاسبي
            $table->string('accounting_system')->nullable()->after('return_policy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn([
                'slogan',
                'cover_image_path',
                'support_phone',
                'support_email',
                'shipping_policy',
                'return_policy',
                'accounting_system'
            ]);
        });
    }
};
