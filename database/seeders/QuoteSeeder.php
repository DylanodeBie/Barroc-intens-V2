<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quote;
use App\Models\Product;
use App\Models\Machine;
use App\Models\Customer;
use App\Models\User;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $machines = Machine::all();
        $beans = Product::where('type', 'coffee_bean')->get();
        $authorizedUsers = User::whereIn('role_id', [7, 10])->get();
        $customers = Customer::all();

        if ($machines->isEmpty() || $beans->isEmpty() || $authorizedUsers->isEmpty() || $customers->isEmpty()) {
            logger()->error('Vereiste data ontbreekt. Zorg ervoor dat klanten, gebruikers, machines en bonen correct zijn geïmporteerd.');
            return;
        }

        for ($i = 0; $i < 120; $i++) {
            $customer = $customers->random();
            $user = $authorizedUsers->random();

            $selectedMachines = $machines->random(rand(1, min($machines->count(), 3)))->map(function ($machine) {
                return [
                    'id' => $machine->id,
                    'quantity' => rand(1, 5),
                ];
            })->toArray();

            $selectedBeans = $beans->random(rand(2, 4))->map(function ($bean) {
                return [
                    'id' => $bean->id,
                    'quantity' => rand(10, 50),
                ];
            })->toArray();

            $quote = Quote::create([
                'customer_id' => $customer->id,
                'user_id' => $user->id,
                'status' => collect(['pending', 'approved', 'rejected'])->random(),
                'quote_date' => now()->subDays(rand(1, 900)),
                'agreement_length' => rand(6, 24) . ' maanden',
                'maintenance_agreement' => collect(['basic', 'standard', 'premium'])->random(),
                'total_price' => 0,
            ]);

            $totalPrice = 0;

            foreach ($selectedMachines as $machineData) {
                $machine = $machines->firstWhere('id', $machineData['id']);
                if ($machine) {
                    $quote->machines()->attach($machine->id, ['quantity' => $machineData['quantity']]);
                    $totalPrice += $machine->lease_price * $machineData['quantity'];
                } else {
                    logger()->warning("Machine met ID {$machineData['id']} bestaat niet.");
                }
            }

            foreach ($selectedBeans as $beanData) {
                $bean = $beans->firstWhere('id', $beanData['id']);
                if ($bean) {
                    $quote->beans()->attach($bean->id, ['quantity' => $beanData['quantity']]);
                    $totalPrice += $bean->price * $beanData['quantity'];
                } else {
                    logger()->warning("Bean met ID {$beanData['id']} bestaat niet.");
                }
            }

            $quote->update(['total_price' => $totalPrice]);
        }
    }
}
