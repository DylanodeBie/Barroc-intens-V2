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
        // Haal data op
        $machines = Machine::all(); // Machines uit de aparte machines-tabel
        $beans = Product::where('type', 'coffee_bean')->get(); // Bonen uit de products-tabel
        $authorizedUsers = User::whereIn('role_id', [7, 10])->get(); // Sales, Head Sales, CEO
        $customers = Customer::all();

        // Controleer of er voldoende data beschikbaar is
        if ($machines->isEmpty() || $beans->isEmpty() || $authorizedUsers->isEmpty() || $customers->isEmpty()) {
            logger()->error('Vereiste data ontbreekt. Zorg ervoor dat klanten, gebruikers, machines en bonen correct zijn geïmporteerd.');
            return;
        }

        // Genereer 100+ offertes
        for ($i = 0; $i < 999; $i++) {
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

            // Maak een nieuwe offerte
            $quote = Quote::create([
                'customer_id' => $customer->id,
                'user_id' => $user->id,
                'status' => collect(['pending', 'approved', 'rejected'])->random(),
                'quote_date' => now()->subDays(rand(1, 60)),
                'agreement_length' => rand(6, 24) . ' maanden',
                'maintenance_agreement' => collect(['basic', 'standard', 'premium'])->random(),
                'total_price' => 0, // Wordt hieronder berekend
            ]);

            $totalPrice = 0;

            // Koppel machines
            foreach ($selectedMachines as $machineData) {
                $machine = $machines->firstWhere('id', $machineData['id']);
                if ($machine) {
                    $quote->machines()->attach($machine->id, ['quantity' => $machineData['quantity']]);
                    $totalPrice += $machine->lease_price * $machineData['quantity'];
                } else {
                    logger()->warning("Machine met ID {$machineData['id']} bestaat niet.");
                }
            }

            // Koppel bonen
            foreach ($selectedBeans as $beanData) {
                $bean = $beans->firstWhere('id', $beanData['id']);
                if ($bean) {
                    $quote->beans()->attach($bean->id, ['quantity' => $beanData['quantity']]);
                    $totalPrice += $bean->price * $beanData['quantity'];
                } else {
                    logger()->warning("Bean met ID {$beanData['id']} bestaat niet.");
                }
            }

            // Update de totaalprijs
            $quote->update(['total_price' => $totalPrice]);
        }
    }
}
