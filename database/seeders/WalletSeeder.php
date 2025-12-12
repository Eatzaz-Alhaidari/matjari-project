<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users who are vendors (role: vendor)
        // If you don't use Spatie permissions, adjust the logic to find vendors.
        // Assuming every user can be a vendor for this demo, or specifically users with 'vendor' role.

        $vendors = User::whereHas('roles', function ($q) {
            $q->where('name', 'vendor');
        })->get();

        // If no vendors found, let's grab some random users just for demo purposes
        if ($vendors->isEmpty()) {
            $vendors = User::inRandomOrder()->take(5)->get();
        }

        foreach ($vendors as $vendor) {
            // Check if wallet already exists
            if (!Wallet::where('vendor_id', $vendor->id)->exists()) {
                $totalEarnings = rand(1000, 50000);
                $withdrawnAmount = rand(0, $totalEarnings);
                $balance = $totalEarnings - $withdrawnAmount;

                Wallet::create([
                    'vendor_id' => $vendor->id,
                    'total_earnings' => $totalEarnings,
                    'withdrawn_amount' => $withdrawnAmount,
                    'balance' => $balance,
                ]);
            }
        }
    }
}
