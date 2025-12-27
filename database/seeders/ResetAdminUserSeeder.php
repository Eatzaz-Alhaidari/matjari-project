<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class ResetAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Ensure role exists
        $role = Role::firstOrCreate(['name' => 'super-admin']);

        $email = 'superadmin@example.com';
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update([
                'password' => Hash::make('password'),
            ]);
            $this->command->info("✅ Admin user found. Password reset to 'password'.");
        } else {
            $user = User::create([
                'name' => 'Super Admin',
                'email' => $email,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $this->command->info("✅ Admin user created.");
        }

        if (!$user->hasRole('super-admin')) {
            $user->assignRole('super-admin');
            $this->command->info("✅ Role 'super-admin' assigned.");
        }

        $this->command->info("---------------------------------------");
        $this->command->info("Login Email: $email");
        $this->command->info("Password:    password");
        $this->command->info("---------------------------------------");
    }
}
