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

        $eligibleUsers = User::whereIn('role_id', [2, 7, 10])->pluck('id')->toArray();

        if (empty($eligibleUsers)) {
            echo "No eligible users (Finance, Head Finance, CEO) found. Seeder aborted.";
            return;
        }

        for ($i = 0; $i < 500; $i++) {
            $createdAt = Carbon::now()->subDays(rand(1, $maxDaysBack));
            $updatedAt = $createdAt->copy()->addHours(rand(1, 48));

            $orders[] = [
                'part_id' => rand(1, 16),
                'user_id' => $faker->randomElement($eligibleUsers),
                'quantity' => rand(1, 100),
                'requires_signature' => $faker->boolean(30),
                'signature_path' => $faker->boolean(30) ? "signatures/order_{$i}.png" : null,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ];
        }

        DB::table('orders')->insert($orders);
    }
}
