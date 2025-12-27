<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\Store;

class CreateVendorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure 'vendor' role exists
        if (!Role::where('name', 'vendor')->exists()) {
            Role::create(['name' => 'vendor']);
        }

        // 2. Create or Update the user
        $email = 'vendor@app.com';
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => 'تاجر تجريبي',
                'email' => $email,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => 'active', // Ensure active status
            ]);
        } else {
            // Update existing user ensuring active status
            $user->update([
                'status' => 'active',
                'password' => Hash::make('password'), // Ensure known password
            ]);
        }

        // 3. Assign role
        if (!$user->hasRole('vendor')) {
            $user->assignRole('vendor');
        }

        // 4. Create a dummy store for this vendor if not exists
        if (!$user->store) {
            Store::create([
                'user_id' => $user->id,
                'name' => 'متجر التاجر التجريبي',
                'slug' => 'vendor-test-store',
                'description' => 'هذا متجر تجريبي لغرض الاختبار',
                'is_active' => true,
            ]);
        }

        $this->command->info("Vendor User Created/Updated Successfully.");
        $this->command->info("Email: {$email}");
        $this->command->info("Password: password");
        $this->command->info("Status: Active");
    }
}
