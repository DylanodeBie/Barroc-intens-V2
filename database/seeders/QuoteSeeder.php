<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quote;
use App\Models\Customer;
use App\Models\User;
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
                    ['id' => 5, 'quantity' => 25],
                    ['id' => 6, 'quantity' => 30],
                ],
            ],
            [
                'customer_id' => 2,
                'user_id' => 3,
                'status' => 'approved',
                'quote_date' => now()->subDays(20),
                'agreement_length' => '24 maanden',
                'maintenance_agreement' => 'premium',
                'machines' => [
                    ['id' => 3, 'quantity' => 1],
                ],
                'beans' => [
                    ['id' => 7, 'quantity' => 20],
                ],
            ],
            [
                'customer_id' => 3,
                'user_id' => 3,
                'status' => 'pending',
                'quote_date' => now()->subDays(15),
                'agreement_length' => '12 maanden',
                'maintenance_agreement' => 'basic',
                'machines' => [
                    ['id' => 2, 'quantity' => 1],
                    ['id' => 4, 'quantity' => 1],
                ],
                'beans' => [
                    ['id' => 6, 'quantity' => 15],
                    ['id' => 8, 'quantity' => 25],
                ],
            ],
            // Voeg hier de overige 17 offertes in dezelfde structuur toe
        ];

        foreach ($quotes as $data) {
            $quote = Quote::create([
                'customer_id' => $data['customer_id'],
                'user_id' => $data['user_id'],
                'status' => $data['status'],
                'quote_date' => $data['quote_date'],
                'agreement_length' => $data['agreement_length'],
                'maintenance_agreement' => $data['maintenance_agreement'],
                'total_price' => 0, // Wordt hieronder berekend
            ]);

            $totalPrice = 0;

            // Machines koppelen
            foreach ($data['machines'] as $machineData) {
                $machine = $machines->find($machineData['id']);
                $quote->machines()->attach($machine->id, ['quantity' => $machineData['quantity']]);
                $totalPrice += $machine->price * $machineData['quantity'];
            }

            // Bonen koppelen
            foreach ($data['beans'] as $beanData) {
                $bean = $beans->find($beanData['id']);
                $quote->beans()->attach($bean->id, ['quantity' => $beanData['quantity']]);
                $totalPrice += $bean->price * $beanData['quantity'];
            }

            // Totale prijs updaten
            $quote->update(['total_price' => $totalPrice]);
        }
    }
}
