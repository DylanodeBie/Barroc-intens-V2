<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $orders = [];
        $maxDaysBack = 900;

        // Get only Finance, Head Finance, and CEO users
        $eligibleUsers = User::whereIn('role_id', [2, 7, 10])->pluck('id')->toArray();

        if (empty($eligibleUsers)) {
            // If no eligible users, stop the seeding process
            echo "No eligible users (Finance, Head Finance, CEO) found. Seeder aborted.";
            return;
        }

        // Generate 500 orders
        for ($i = 0; $i < 500; $i++) {
            $createdAt = Carbon::now()->subDays(rand(1, $maxDaysBack));
            $updatedAt = $createdAt->copy()->addHours(rand(1, 48)); // Random update time within 48 hours of creation

            $orders[] = [
                'part_id' => rand(1, 16), // Random part_id between 1 and 16 (your parts table)
                'user_id' => $faker->randomElement($eligibleUsers), // Random eligible user
                'quantity' => rand(1, 100), // Random quantity between 1 and 100
                'requires_signature' => $faker->boolean(30), // 30% chance of requiring a signature
                'signature_path' => $faker->boolean(30) ? "signatures/order_{$i}.png" : null, // Only if signature is required
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ];
        }

        // Insert all orders into the database
        DB::table('orders')->insert($orders);
    }
}
