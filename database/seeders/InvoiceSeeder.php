<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Haal klanten, gebruikers en producten op
        $customers = Customer::all();
        $authorizedUsers = User::whereIn('role_id', [7, 10])->get(); // Sales, Head Sales, en CEO
        $products = Product::all();

        // Genereer 100+ facturen
        for ($i = 0; $i < 999; $i++) {
            // Kies willekeurig een klant en een geautoriseerde gebruiker
            $customer = $customers->random();
            $user = $authorizedUsers->random();

            // Maak een nieuwe factuur
            $invoice = Invoice::create([
                'customer_id' => $customer->id,
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . now()->timestamp . '-' . $customer->id . '-' . $i,
                'invoice_date' => now()->subDays(rand(1, 90)), // Willekeurige datum binnen de laatste 90 dagen
                'notes' => 'Dit is een automatisch gegenereerde factuur.',
                'total_amount' => 0,
            ]);

            $totalAmount = 0;

            // Voeg 2-4 willekeurige producten toe aan de factuur
            $selectedProducts = $products->random(rand(2, 4));

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 5); // Hoeveelheid tussen 1 en 5
                $subtotal = $product->price * $quantity;

                // Maak een factuurregel aan
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $product->name,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }

            // Update het totaalbedrag van de factuur
            $invoice->update(['total_amount' => $totalAmount]);
        }
    }
}
