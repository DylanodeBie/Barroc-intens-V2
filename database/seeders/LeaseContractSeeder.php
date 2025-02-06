<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaseContract;
use App\Models\Product;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class LeaseContractSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $customers = Customer::all();
        $products = Product::all();
        $users = User::where('role_id', 2)->get();

        if ($users->isEmpty()) {
            $this->command->error('Geen gebruikers gevonden met role_id = 2. Voeg deze toe voordat je deze seeder uitvoert.');
            return;
        }

        for ($i = 0; $i < 920; $i++) {
            $customer = $customers->random();
            $user = $users->random();

            if ($i < 8) {
                $startDate = Carbon::now()->subYears(2);
                $endDate = Carbon::now()->subYear(1);
                $status = 'overdue';
            } else {
                $startDate = Carbon::now()->subMonths(rand(1, 6));
                $endDate = $startDate->copy()->addMonths(rand(12, 24));
                $status = $faker->randomElement(['pending', 'completed', 'rejected', 'overdue']);
            }

            $paymentMethod = $faker->randomElement(['maandelijks', 'per kwartaal']);
            $machineAmount = rand(1, 10);
            $noticePeriod = $faker->randomElement([14, 7, 21]);

            $leaseContract = LeaseContract::create([
                'customer_id' => $customer->id,
                'user_id' => $user->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'payment_method' => $paymentMethod,
                'machine_amount' => $machineAmount,
                'notice_period' => $noticePeriod,
                'status' => $status,
                'total_price' => 0,
            ]);

            $selectedProducts = $products->random(3);

            $productDetails = $selectedProducts->mapWithKeys(function ($product) {
                return [
                    $product->id => [
                        'price' => $product->price,
                        'amount' => rand(1, 5),
                    ],
                ];
            });

            $leaseContract->products()->attach($productDetails);

            $totalPrice = $productDetails->reduce(function ($carry, $details) {
                return $carry + ($details['price'] * $details['amount']);
            }, 0);

            $leaseContract->update(['total_price' => $totalPrice]);

            if ($status == 'completed') {
                $approvedBy = $users->random();
                $leaseContract->update([
                    'approval_reason' => $faker->sentence(),
                    'approved_by' => $approvedBy->id,
                ]);
            } elseif ($status == 'rejected') {
                $rejectedBy = $users->random();
                $leaseContract->update([
                    'rejection_reason' => $faker->sentence(),
                    'rejected_by' => $rejectedBy->id,
                ]);
            }
        }
    }
}
