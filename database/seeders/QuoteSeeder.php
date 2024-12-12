<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quote;
use App\Models\Product;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $machines = Product::where('type', 'machine')->get();
        $beans = Product::where('type', 'coffee_bean')->get();

        $quotes = [
            [
                'customer_id' => 1,
                'user_id' => 3,
                'status' => 'pending',
                'quote_date' => now()->subDays(10),
                'agreement_length' => '12 maanden',
                'maintenance_agreement' => 'basic',
                'machines' => [
                    ['id' => 1, 'quantity' => 1],
                    ['id' => 2, 'quantity' => 2],
                ],
                'beans' => [
                    ['id' => 10, 'quantity' => 25],
                    ['id' => 11, 'quantity' => 30],
                ],
            ],
            // Add more quotes here...
        ];

        foreach ($quotes as $data) {
            $quote = Quote::create([
                'customer_id' => $data['customer_id'],
                'user_id' => $data['user_id'],
                'status' => $data['status'],
                'quote_date' => $data['quote_date'],
                'agreement_length' => $data['agreement_length'],
                'maintenance_agreement' => $data['maintenance_agreement'],
                'total_price' => 0, // Calculated below
            ]);

            $totalPrice = 0;

            // Link machines
            foreach ($data['machines'] as $machineData) {
                $machine = $machines->firstWhere('id', $machineData['id']);
                if ($machine) {
                    $quote->machines()->attach($machine->id, ['quantity' => $machineData['quantity']]);
                    $totalPrice += $machine->price * $machineData['quantity'];
                } else {
                    logger()->warning("Machine with ID {$machineData['id']} not found.");
                }
            }

            // Link beans
            foreach ($data['beans'] as $beanData) {
                $bean = $beans->firstWhere('id', $beanData['id']);
                if ($bean) {
                    $quote->beans()->attach($bean->id, ['quantity' => $beanData['quantity']]);
                    $totalPrice += $bean->price * $beanData['quantity'];
                } else {
                    logger()->warning("Bean with ID {$beanData['id']} not found.");
                }
            }

            // Update total price
            $quote->update(['total_price' => $totalPrice]);
        }
    }
}
