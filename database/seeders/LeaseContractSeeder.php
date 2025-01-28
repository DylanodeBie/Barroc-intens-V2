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
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create(); // Initialiseer de Faker generator

        // Verkrijg alle klanten uit de database
        $customers = Customer::all();

        // Verkrijg alle producten uit de database
        $products = Product::all();

        // Verkrijg alle gebruikers met role_id = 2
        $users = User::where('role_id', 2)->get();

        // Controleer of er gebruikers met role_id = 2 beschikbaar zijn
        if ($users->isEmpty()) {
            $this->command->error('Geen gebruikers gevonden met role_id = 2. Voeg deze toe voordat je deze seeder uitvoert.');
            return;
        }

        // Maak 120 LeaseContracten
        for ($i = 0; $i < 120; $i++) {
            // Kies een willekeurige klant
            $customer = $customers->random();

            // Kies een willekeurige gebruiker met role_id = 2
            $user = $users->random();

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
                $status = $faker->randomElement(['pending', 'completed', 'overdue']); // Willekeurige status
            }

            // Willekeurige betaalmethode: maandelijks of per kwartaal
            $paymentMethod = $faker->randomElement(['maandelijks', 'per kwartaal']);

            // Willekeurig aantal machines (tussen 1 en 10)
            $machineAmount = rand(1, 10);

            // Willekeurige opzegtermijn (14, 7 of 21 dagen)
            $noticePeriod = $faker->randomElement([14, 7, 21]);

            // Maak een LeaseContract zonder de totale prijs in te vullen
            $leaseContract = LeaseContract::create([
                'customer_id' => $customer->id,
                'user_id' => $user->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'payment_method' => $paymentMethod,
                'machine_amount' => $machineAmount,
                'notice_period' => $noticePeriod,
                'status' => $status,
                'total_price' => 0, // Placeholder, wordt later berekend
            ]);

            // Selecteer willekeurig 3 producten
            $selectedProducts = $products->random(3);

            // Maak een array met productgegevens (prijzen en aantallen)
            $productDetails = $selectedProducts->mapWithKeys(function ($product) {
                return [
                    $product->id => [
                        'price' => $product->price, // Zorg dat je een 'price'-eigenschap hebt
                        'amount' => rand(1, 5),  // Stel een willekeurig aantal in (bijvoorbeeld tussen 1 en 5)
                    ],
                ];
            });

            // Koppel de producten aan het leasecontract met extra gegevens
            $leaseContract->products()->attach($productDetails);

            // Bereken de totale prijs van het leasecontract
            $totalPrice = $productDetails->reduce(function ($carry, $details) {
                return $carry + ($details['price'] * $details['amount']);
            }, 0);

            // Werk de total_price bij in het leasecontract
            $leaseContract->update(['total_price' => $totalPrice]);
        }
    }
}