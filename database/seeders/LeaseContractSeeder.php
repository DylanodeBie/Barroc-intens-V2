<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaseContract;
use App\Models\Product;
use Carbon\Carbon;
use Faker\Factory as Faker;

class LeaseContractSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create(); // Initialiseer de Faker generator

        // Maak 120 LeaseContracten
        for ($i = 0; $i < 120; $i++) {
            // Voeg een voorwaardelijke logica toe voor verlopen contracten
            if ($i < 8) {
                // Maak een verlopen contract
                $startDate = Carbon::now()->subYears(2); // Startdatum 2 jaar geleden
                $endDate = Carbon::now()->subYear(1); // Einddatum 1 jaar geleden
                $status = 'overdue'; // Zet de status op 'overdue'
            } else {
                // Genereer een willekeurige startdatum tussen 1 en 6 maanden geleden
                $startDate = Carbon::now()->subMonths(rand(1, 6));
                
                // Genereer een willekeurige einddatum, altijd minstens 12 maanden na de startdatum
                $endDate = $startDate->copy()->addMonths(rand(12, 24));
                $status = $faker->randomElement(['actief', 'pending', 'completed', 'overdue']); // Willekeurige status
            }

            // Willekeurige betaalmethode: maandelijks of per kwartaal
            $paymentMethod = $faker->randomElement(['maandelijks', 'per kwartaal']);

            // Willekeurig aantal machines (tussen 1 en 10)
            $machineAmount = rand(1, 10);

            // Willekeurige opzegtermijn (14, 7 of 21 dagen)
            $noticePeriod = $faker->randomElement([14, 7, 21]);

            // Maak een LeaseContract
            $leaseContract = LeaseContract::create([
                'customer_id' => 1, // Dit moet overeenkomen met een bestaand klant-ID
                'user_id' => 1, // Dit moet overeenkomen met een bestaand medewerker-ID
                'start_date' => $startDate,
                'end_date' => $endDate,
                'payment_method' => $paymentMethod,
                'machine_amount' => $machineAmount,
                'notice_period' => $noticePeriod,
                'status' => $status,
            ]);

            // Verkrijg een lijst van producten uit de database
            $products = Product::all();

            // Koppel willekeurige producten (3 producten) aan het contract
            $leaseContract->products()->attach(
                $products->random(3)->pluck('id')->toArray() // Selecteer willekeurig 3 producten
            );
        }
    }
}