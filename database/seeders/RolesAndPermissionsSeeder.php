<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // <--- لا تنسي استدعاء مودل Role من Spatie
use App\Models\User;               // <--- لا تنسي استدعاء مودل المستخدم الخاص بكِ

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // هذا السطر مهم جداً. يقوم بإعادة تحميل (forget) الأدوار والصلاحيات
        // المخزنة مؤقتاً في ذاكرة Laravel، لضمان أن التغييرات الجديدة تطبق.
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // إنشاء الأدوار التي سنستخدمها في نظامنا
        Role::create(['name' => 'super-admin']); // الأدمن الأعلى له كل الصلاحيات
        Role::create(['name' => 'vendor']);      // البائع له صلاحيات محدودة

        // إنشاء مستخدم Super Admin افتراضي
        // نستخدم User::create لأن $fillable تم تحديده في Model User
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => 'password' // كلمة المرور الافتراضية هي 'password'
        ]);

        // منح دور 'super-admin' للمستخدم الذي تم إنشاؤه
        // هذه الدالة 'assignRole' تأتي من الـ trait Spatie\Permission\Traits\HasRoles
        $user->assignRole('super-admin');
    }
}